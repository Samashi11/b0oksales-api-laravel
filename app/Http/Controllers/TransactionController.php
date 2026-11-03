<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{

    public function index(): JsonResponse
    {
        $daftar = Transaction::with(['customer', 'book'])->latest('id')->get();

        return $this->sukses($daftar, 'Get All Resource');
    }

    public function destroy(Transaction $transaction): JsonResponse
    {
        $transaction->delete();

        return $this->sukses(null, 'Resource deleted successfully');
    }


    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'order_number' => 'required|string|max:50|unique:transactions,order_number',
            'book_id'      => 'required|integer|exists:books,id',
            'quantity'     => 'required|integer|min:1|max:1000',
            // dua field ini dihitung/diisi server, klien dilarang mengirimnya
            'customer_id'  => 'prohibited',
            'total_amount' => 'prohibited',
        ]);

        $buku = Book::findOrFail($data['book_id']);

        $transaksi = $request->user()->transactions()->create([
            'order_number' => $data['order_number'],
            'book_id'      => $buku->id,
            'quantity'     => $data['quantity'],
            'total_amount' => $this->hitungTotal($buku, $data['quantity']),
        ]);

        return $this->sukses($transaksi->load(['customer', 'book']), 'Resource created successfully', 201);
    }

    public function show(Request $request, Transaction $transaction): JsonResponse
    {
        $this->pastikanMilikSendiri($request, $transaction);

        return $this->sukses($transaction->load(['customer', 'book']), 'Get Detail Resource');
    }

    public function update(Request $request, Transaction $transaction): JsonResponse
    {
        $this->pastikanMilikSendiri($request, $transaction);

        $data = $request->validate([
            'order_number' => [
                'sometimes', 'required', 'string', 'max:50',
                Rule::unique('transactions', 'order_number')->ignore($transaction->id),
            ],
            'book_id'      => 'sometimes|required|integer|exists:books,id',
            'quantity'     => 'sometimes|required|integer|min:1|max:1000',
            'customer_id'  => 'prohibited',
            'total_amount' => 'prohibited',
        ]);

        if (isset($data['book_id']) || isset($data['quantity'])) {
            $buku = isset($data['book_id']) ? Book::findOrFail($data['book_id']) : $transaction->book;
            $jumlah = $data['quantity'] ?? $transaction->quantity;

            $data['total_amount'] = $this->hitungTotal($buku, $jumlah);
        }

        $transaction->update($data);

        return $this->sukses($transaction->load(['customer', 'book']), 'Resource updated successfully');
    }


    private function pastikanMilikSendiri(Request $request, Transaction $transaction): void
    {
        abort_unless((int) $transaction->customer_id === (int) $request->user()->id, 404);
    }

    private function hitungTotal(Book $buku, int $jumlah): string
    {
        $sen = (int) round(((float) $buku->price) * 100) * $jumlah;

        return number_format($sen / 100, 2, '.', '');
    }
}
