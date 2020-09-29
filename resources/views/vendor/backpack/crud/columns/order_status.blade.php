<span class="d-block
    @if($entry->final_status == 'pending') text-warning @endif
    @if($entry->final_status == 'cancelled') text-danger @endif
    @if($entry->final_status == 'confirmed') text-primary @endif
    @if($entry->final_status == 'processed') text-dark @endif
    @if($entry->final_status == 'shipped') text-info @endif
    @if($entry->final_status == 'delivered / ended') text-success @endif



    ">
    {{ $entry->final_status }}
</span>
