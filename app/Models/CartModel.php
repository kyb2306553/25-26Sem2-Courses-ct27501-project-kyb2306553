<?php

namespace App\Models;

class CartModel
{
    private string $sessionKey = 'cart';

    public function getCart()
    {
        return $_SESSION[$this->sessionKey] ?? [];
    }

    public function add($productId, $quantity, $stock)
    {
        $cart = $this->getCart();
        $currentQuantity = $cart[$productId] ?? 0;
        $newQuantity = $currentQuantity + $quantity;

        $cart[$productId] = min($newQuantity, max($stock, 0));
        $_SESSION[$this->sessionKey] = $cart;
    }

    public function update($productId, $quantity, $stock)
    {
        $cart = $this->getCart();

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = min($quantity, max($stock, 0));
        }

        $_SESSION[$this->sessionKey] = $cart;
    }

    public function remove($productId)
    {
        $cart = $this->getCart();
        unset($cart[$productId]);
        $_SESSION[$this->sessionKey] = $cart;
    }

    public function clear()
    {
        $_SESSION[$this->sessionKey] = [];
    }

    public function getTotalQuantity()
    {
        return array_sum($this->getCart());
    }
}
