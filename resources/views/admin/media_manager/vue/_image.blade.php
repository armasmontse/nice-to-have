<single-image
    v-ref:{{ $vref }}
    current-image="{{ json_encode($object->getFirstPhotoTo( [ "use" => $use, "order" => $order ] ))   }}"
    type="{{ $type }}"
    photoable-id="{{ $object->id }}"
    photoable-type="{{ $object->getPhotoableCode() }}"
    use="{{ $use }}"
    class="{{ $class }}"
    default-order="{{ $order }}"
    >
@include('admin.media_manager.vue._image-placeholder-slot')
</single-image>
