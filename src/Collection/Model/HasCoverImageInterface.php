<?php

namespace App\Collection\Model;

interface HasCoverImageInterface
{
    public function getThumbUrl(): string;
    public function getIconUrl(): string;
    public function getDetailUrl(): string;
    public function getBlurHash(): string;
}
