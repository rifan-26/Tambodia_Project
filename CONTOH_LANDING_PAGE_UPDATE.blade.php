{{-- CONTOH UPDATE LANDING PAGE --}}
{{-- Copy bagian ini dan ganti di landingpage.blade.php --}}

{{-- ========================================= --}}
{{-- BAGIAN GALLERY ITEMS - GANTI SEMUA INI --}}
{{-- ========================================= --}}

<div class="gallery">
  <div class="row">
    <div class="col-3">
      <!-- Item 1: Portrait kiri atas -->
      <div class="gallery-item">
        @php $item1 = $media->where('layout_order', 1)->first(); @endphp
        <x-media-renderer :media="$item1" />
      </div>
    </div>
    
    <div class="col-9">
      <!-- Item 2: Landscape besar kanan atas -->
      <div class="gallery-item">
        @php $item2 = $media->where('layout_order', 2)->first(); @endphp
        <x-media-renderer :media="$item2" />
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-6">
      <!-- Item 3: Portrait tengah kiri -->
      <div class="gallery-item">
        @php $item3 = $media->where('layout_order', 3)->first(); @endphp
        <x-media-renderer :media="$item3" />
      </div>
    </div>
    
    <div class="col-3">
      <!-- Item 4: Portrait tengah kanan -->
      <div class="gallery-item">
        @php $item4 = $media->where('layout_order', 4)->first(); @endphp
        <x-media-renderer :media="$item4" />
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-3">
      <!-- Item 5: Portrait bawah kiri -->
      <div class="gallery-item">
        @php $item5 = $media->where('layout_order', 5)->first(); @endphp
        <x-media-renderer :media="$item5" />
      </div>
    </div>
    
    <div class="col-3">
      <!-- Item 6: Portrait bawah kanan -->
      <div class="gallery-item">
        @php $item6 = $media->where('layout_order', 6)->first(); @endphp
        <x-media-renderer :media="$item6" />
      </div>
    </div>
  </div>
</div>

{{-- ========================================= --}}
{{-- SELESAI - BAGIAN YANG PERLU DIGANTI --}}
{{-- ========================================= --}}
