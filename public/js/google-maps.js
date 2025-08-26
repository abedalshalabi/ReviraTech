function initMap() {
    const map = new google.maps.Map(document.getElementById('map'), {
        center: { 
            lat: {{ $settings['map_latitude'] ?? 24.7136 }}, 
            lng: {{ $settings['map_longitude'] ?? 46.6753 }} 
        },
        zoom: {{ $settings['map_zoom'] ?? 15 }}
    });

    const marker = new google.maps.Marker({
        position: { 
            lat: {{ $settings['map_latitude'] ?? 24.7136 }}, 
            lng: {{ $settings['map_longitude'] ?? 46.6753 }} 
        },
        map: map,
        title: '{{ $settings["site_name"] ?? "Revira Industrial" }}'
    });
}