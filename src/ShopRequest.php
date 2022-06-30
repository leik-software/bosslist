<?php declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class ShopRequest
{
    private RequestStack $requestStack;
    private SessionInterface $session;

    public function __construct(RequestStack $requestStack, SessionInterface $session)
    {
        $this->requestStack = $requestStack;
        $this->session = $session;
    }

    public function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    public function hasRequest(): bool
    {
        return $this->requestStack->getCurrentRequest() instanceof Request;
    }

    public function hasSession(): bool
    {
        return true;
    }

    public function getSession(): SessionInterface
    {
        return $this->session;
    }
}
