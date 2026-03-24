<?php

namespace App\Models;

class CartModel
{
    private string $sessionKey = 'carts_by_user';

    public function getCart()
    {
        $userId = $this->getCurrentUserId();
        if ($userId === null) {
            return [];
        }

        $storage = $this->getCartStorage();
        $cart = $storage[$userId] ?? [];

        return is_array($cart) ? $cart : [];
    }

    public function add($productId, $quantity, $stock)
    {
        $cart = $this->getCart();
        $currentQuantity = $cart[$productId] ?? 0;
        $newQuantity = $currentQuantity + $quantity;

        $cart[$productId] = min($newQuantity, max($stock, 0));
        $this->saveCart($cart);
    }

    public function update($productId, $quantity, $stock)
    {
        $cart = $this->getCart();

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = min($quantity, max($stock, 0));
        }

        $this->saveCart($cart);
    }

    public function remove($productId)
    {
        $cart = $this->getCart();
        unset($cart[$productId]);
        $this->saveCart($cart);
    }

    public function clear()
    {
        $this->saveCart([]);
    }

    public function getTotalQuantity()
    {
        return array_sum($this->getCart());
    }

    private function saveCart(array $cart): void
    {
        $userId = $this->getCurrentUserId();
        if ($userId === null) {
            return;
        }

        $storage = $this->getCartStorage();
        $storage[$userId] = $cart;
        $_SESSION[$this->sessionKey] = $storage;
    }

    private function getCartStorage(): array
    {
        $storage = $_SESSION[$this->sessionKey] ?? [];
        return is_array($storage) ? $storage : [];
    }

    private function getCurrentUserId(): ?int
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if ($userId === null) {
            return null;
        }

        $userId = (int) $userId;
        return $userId > 0 ? $userId : null;
    }
}
