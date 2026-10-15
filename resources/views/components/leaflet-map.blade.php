<div id="mapid" style="height: 400px; width: 100%;"></div>

@push("scripts")
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var map = L.map("mapid").setView([0, 0], 13); // Default view, will be updated

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // You can add markers or other Leaflet elements here
        // Example: L.marker([51.5, -0.09]).addTo(map).bindPopup("A pretty CSS3 popup.<br>Easily customizable.").openPopup();

        // Fit map to markers if any, or set a default view if no markers
        @if(isset($cagarBudaya)) // Assuming $cagarBudaya is passed with latitude and longitude
            var lat = {{ $cagarBudaya->location->latitude }};
            var lng = {{ $cagarBudaya->location->longitude }};
            map.setView([lat, lng], 16); // Set view to specific cagar budaya location
            L.marker([lat, lng]).addTo(map)
                .bindPopup("<b>{{ $cagarBudaya->name }}</b><br>{{ $cagarBudaya->short_description }}").openPopup();
        @endif
    });
</script>
@endpush