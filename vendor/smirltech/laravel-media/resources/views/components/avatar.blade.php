@props(['model','edit'=>false,'size' => 100,'refresh'=>true])
<div
    @if($edit)
        onclick="openAvatarModal('{{ class_basename($model) }}','{{ $model->id }}')"
    @endif
    class="img text-center">
    @if($edit)
        <span class="badge badge-primary p-2">
        <i class="fa fa-camera-alt"></i>
   </span>
    @endif
    <img style="width:{{$size}}px; height:{{$size}}px;border-radius: 50%;object-fit: cover"
         src="{{$model?->avatar}}"
         alt="Picture">
</div>
<style>
    .img {
        position: relative;
    }

    .img span {
        top: 50%;
        left: 50%;
        position: absolute;
        transform: translate(-50%, -50%);
        color: white;
    }
</style>
<script>
    function openAvatarModal(model, id) {
        console.log('openAvatarModal', model, id);
        Livewire.emit('showModal', 'media::avatar-component', model, id);
    }
</script>
@if($refresh)
    @push('js')
        <script>
            Livewire.on('avatarUpdated', () => {
                window.location.reload();
            });
        </script>
    @endpush
@endif
