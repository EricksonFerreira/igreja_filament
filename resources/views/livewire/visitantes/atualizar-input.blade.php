<div>
    <input type="text" wire:model.defer="valor" wire:change="salvar">
</div>
<script>
    $(document).on('change', '.detalhe-input', function() {
    var id = $(this).closest('tr').data('id');
    var valor = $(this).val();

    Livewire.emit('atualizarInput', id, valor);
});
</script>
