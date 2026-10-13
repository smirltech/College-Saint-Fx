@props(['media'=>[],'model'=>null,'delete' => false])
@php($media=$model?->$media?:$media)
<ol class="list-group mt-3">
    @foreach($media as $m)
        <li class="list-group-item">
            <i class="fa fa-{{$m->icon}}"></i>
            <a class="" title="Voir"
               href="{{route('media.show', $m)}}"
               target="_blank">{{$m->filename}}</a>
            @if($delete)
                | <i title="Supprimer" wire:loading.remove wire:target="deleteMedia" wire:click="deleteMedia('{{$m->id}}')"
                     class="fa fa-times-circle text-danger"></i>
            @endif

        </li>
    @endforeach
</ol>
