<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\Product;
use Exception;

class StockService
{
    public static function updateStock($productId, $units)
    {
        $product = Product::find($productId);

        if (!$product) {
            throw new Exception("Produto não encontrado.");
        }

        $quantityPerUnit = $product->quantity;
        $totalQuantityAdded = $units * $quantityPerUnit;

        $product->qtd_stock += $totalQuantityAdded;

        $product->save();

        return true;
    }

    public function decreaseStock($productId, $quantity)
    {
        $product = Product::find($productId);

        if (!$product) {
            throw new Exception("Produto não encontrado.");
        }

        $quantityPerUnit = $product->quantity;
        $totalQuantityRemoved = $quantity * $quantityPerUnit;

        $product->qtd_stock -= $totalQuantityRemoved;

        $product->save();

        return true;
    }

    public static function updateStockEntry($inventoryId, $newQuantity)
    {
        // Buscar a entrada de estoque original
        $inventory = Inventory::findOrFail($inventoryId);

        if (!$inventory) {
            throw new Exception("Entrada não encontrada.");
        }

        // Buscar o produto relacionado à entrada
        $product = Product::findOrFail($inventory->product_id);

        if (!$product) {
            throw new Exception("Produto não encontrado.");
        }

        // Quantidade antiga (antes da atualização)
        $oldQuantity = $inventory->quantity;  // Quantidade de embalagens registrada na entrada anterior

        // Calcular a quantidade total que foi adicionada ou removida do estoque
        $unitQuantity = $product->quantity; // Quantidade de produto por embalagem
        $stockChange = ($newQuantity - $oldQuantity) * $unitQuantity;

        // Atualizar o campo `qtd_stock` no produto
        $product->qtd_stock += $stockChange;

        // Salvar a atualização no produto
        $product->save();

        // Atualizar a quantidade na entrada de estoque
        $inventory->quantity = $newQuantity;
        $inventory->save();

        return true;
    }

    public static function deleteStockEntry($inventoryId)
    {
        // Buscar a entrada de estoque original
        $inventory = Inventory::findOrFail($inventoryId);

        if (!$inventory) {
            throw new Exception("Entrada não encontrada.");
        }

        // Buscar o produto relacionado à entrada
        $product = Product::findOrFail($inventory->product_id);

        if (!$product) {
            throw new Exception("Produto não encontrado.");
        }

        // Quantidade de embalagens registrada na entrada original
        $oldQuantity = $inventory->quantity;

        // Quantidade total que foi adicionada ao estoque (com base nas embalagens)
        $unitQuantity = $product->quantity; // Quantidade de produto por embalagem
        $stockChange = $oldQuantity * $unitQuantity;

        // Atualizar o campo `qtd_stock`, removendo a quantidade adicionada por essa entrada
        $product->qtd_stock -= $stockChange;

        // Salvar as alterações no produto
        $product->save();

        // Excluir a entrada de estoque
        $inventory->delete();

        return true;
    }
}
