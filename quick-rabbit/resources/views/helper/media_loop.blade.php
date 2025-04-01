 @foreach ($data as $key=>$media)
<div class="file_media cursor-pointer col-xl-2 col-lg-2 col-md-3 col-sm-4" data-src="{{ asset($media->media_path) }}">
    <figure>
      <img src="{{asset($media->thumb_img)}}" class="img-fluid p-1" width="100%" >
      <figcaption class="text-truncate">
          <small class="media_title_text">
            {{ $media->title ?? "" }}
        </small>
      </figcaption>
    </figure>
</div>
@endforeach
