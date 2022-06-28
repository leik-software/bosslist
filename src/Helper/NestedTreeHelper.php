<?php declare(strict_types=1);

namespace App\Helper;

use Assert\Assertion;
use Doctrine\DBAL\Connection;

final class NestedTreeHelper
{
    /**
     * @see https://github.com/wuda-io/TreeClass/blob/master/wuda.cls_tree.php
     */
    public static function addItem(Connection $connection, string $tableName, string $title, int $parentId, ?int $id = null): int
    {
        try{
            $rgt = $connection->executeQuery("SELECT rgt FROM ".$tableName." WHERE id = $parentId;")->fetchOne();
            Assertion::notEmpty($rgt);
            $connection->beginTransaction();
            $connection->executeQuery("UPDATE ".$tableName." SET rgt=rgt+2 WHERE rgt >= $rgt;");
            $connection->executeQuery("UPDATE ".$tableName." SET lft=lft+2 WHERE lft > $rgt;");
            if($id){
                $connection->executeQuery("INSERT INTO ".$tableName." (id,parent_id,title,lft,rgt) VALUES ($id, $parentId, '$title', $rgt, $rgt+1);");
            }else{
                $connection->executeQuery("INSERT INTO ".$tableName." (parent_id,title,lft,rgt) VALUES ($parentId, '$title', $rgt, $rgt+1);");
            }
            $id = (int)$connection->lastInsertId();
            $connection->commit();
            return $id;
        }catch (\Throwable $exception){
            if($connection->isTransactionActive()){
                $connection->rollBack();
            }
            throw $exception;
        }
    }

    public static function deleteItem(Connection $connection, string $tableName, int $left, int $right): void
    {
        $connection->executeQuery(
            "DELETE FROM ".$tableName." WHERE lft BETWEEN ? AND ?;",
            [$left, $right],
            [\PDO::PARAM_INT,\PDO::PARAM_INT]
        );
        $connection->executeQuery(
            "UPDATE ".$tableName." SET lft=lft-ROUND((?-?+1)) WHERE lft>?;",
            [$right, $left, $right],
            [\PDO::PARAM_INT, \PDO::PARAM_INT, \PDO::PARAM_INT]
        );
        $connection->executeQuery(
            "UPDATE ".$tableName." SET rgt=rgt-ROUND((?-?+1)) WHERE rgt>?;",
            [$right, $left, $right],
            [\PDO::PARAM_INT, \PDO::PARAM_INT, \PDO::PARAM_INT]
        );
    }

    /**
     * @see https://rogerkeays.com/how-to-move-a-node-in-nested-sets-with-sql
     */
    public static function moveItem(Connection $connection, string $tableName, int $movedId, int $parentId, int $position): void
    {
        $movedNode = $connection->executeQuery(sprintf('SELECT * FROM %s WHERE id = %d', $tableName, $movedId))->fetchAssociative();
        $siblings = $connection->executeQuery(sprintf('SELECT lft FROM %s WHERE parent_id = %d ORDER BY lft ASC', $tableName, $parentId))->fetchAllAssociative();
        $newLeft = 0;
        if(!count($siblings) && !$position){
            $newLeft = $connection->executeQuery(sprintf('SELECT lft FROM %s WHERE id = %d', $tableName, $parentId))->fetchOne()+1;
        }elseif(count($siblings) === $position){
            //last position
            $newLeft = array_pop($siblings)['lft'];
        }else{
            foreach ($siblings as $index => $sibling){
                if($index === $position){
                    $newLeft = $sibling['lft'];
                    break;
                }
            }
        }
        Assertion::notEmpty($newLeft);
        $width = $movedNode['rgt'] - $movedNode['lft'] + 1;
        $distance = $newLeft - $movedNode['lft'];
        $tmppos = $movedNode['lft'];
        if($distance < 0){
            $distance -= $width;
            $tmppos += $width;
        }
        $connection->executeQuery(sprintf('UPDATE %s SET lft = lft + %d WHERE lft >= %d', $tableName, $width, $newLeft));
        $connection->executeQuery(sprintf('UPDATE %s SET rgt = rgt + %d WHERE rgt >= %d', $tableName, $width, $newLeft));
        $connection->executeQuery(sprintf('UPDATE %s SET lft = lft + %d, rgt = rgt + %d WHERE lft >= %d AND rgt < %d + %d', $tableName, $distance, $distance, $tmppos, $tmppos, $width));
        $connection->executeQuery(sprintf('UPDATE %s SET lft = lft - %d WHERE lft > %d', $tableName, $width, $movedNode['rgt']));
        $connection->executeQuery(sprintf('UPDATE %s SET rgt = rgt - %d WHERE rgt > %d', $tableName, $width, $movedNode['rgt']));
        $connection->executeQuery(sprintf('UPDATE %s SET parent_id = %d WHERE id = %d', $tableName, $parentId, $movedNode['id']));

    }

}
