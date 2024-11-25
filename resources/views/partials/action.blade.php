<form action="{{ route('cart.update') }}" method="POST" class="relative">
  @csrf
  <input type="hidden" name="type" value="add">
  <input type="hidden" name="cart_id" value="{{ $item->id }}">
  <button type="submit" class="p-2 peer bg-border/50 hover:text-background hover:bg-accent rounded-xl aspect-square">
    <i data-lucide="plus" class="size-4"></i>
  </button>
  <span
    class="absolute z-10 px-2 py-1 text-sm text-center transition-all ease-out -translate-x-1/2 rounded-lg opacity-0 text-background bg-primary -bottom-9 left-1/2 whitespace-nowrap peer-hover:opacity-100 peer-focus:opacity-100"
    role="tooltip">
    Tambah Item
  </span>
</form>

<form action="{{ route('cart.update') }}" method="POST" class="relative">
  @csrf
  <input type="hidden" name="type" value="subtract">
  <input type="hidden" name="cart_id" value="{{ $item->id }}">
  <button type="submit" class="p-2 peer bg-border/50 hover:text-background hover:bg-accent rounded-xl aspect-square">
    <i data-lucide="minus" class="size-4"></i>
  </button>
  <span
    class="absolute z-10 px-2 py-1 text-sm text-center transition-all ease-out -translate-x-1/2 rounded-lg opacity-0 text-background bg-primary -bottom-9 left-1/2 whitespace-nowrap peer-hover:opacity-100 peer-focus:opacity-100"
    role="tooltip">
    Kurangi Item
  </span>
</form>

<form action="{{ route('cart.update') }}" method="POST" class="relative">
  @csrf
  <input type="hidden" name="type" value="remove">
  <input type="hidden" name="cart_id" value="{{ $item->id }}">
  <button type="submit" class="p-2 peer bg-border/50 hover:text-background hover:bg-red-600 rounded-xl aspect-square">
    <i data-lucide="trash" class="size-4"></i>
  </button>
  <span
    class="absolute z-10 px-2 py-1 text-sm text-center transition-all ease-out -translate-x-1/2 rounded-lg opacity-0 text-background bg-primary -bottom-9 left-1/2 whitespace-nowrap peer-hover:opacity-100 peer-focus:opacity-100"
    role="tooltip">
    Hapus Item
  </span>
</form>
