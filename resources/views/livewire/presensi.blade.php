<div>
    <div class="container mx-auto max-w-sm">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="grid grid-cols-1 gap-6 mb-6">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Informasi Pegawai</h2>
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <p><strong>Nama Pegawai: </strong>{{ $schedule->user->name }}</p>
                        <p><strong>Kantor: </strong>{{ $schedule->office->name }}</p>
                        <p><strong>Shift: </strong>{{ $schedule->shift->name }}</p>
                        @if ($schedule->iswfa)
                            <p class="text-green-300"><strong>Status: </strong>WFA</p>
                        @else 
                            <p><strong>Status: </strong>WFO</p>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h4 class="text-lg font-bold mb-2">Jam Masuk</h4>
                            <p>{{ $attendance->start_time ?? 'Belum Absen' }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h4 class="text-lg font-bold mb-2">Jam Keluar</h4>
                            <p>{{ $attendance->end_time ?? 'Belum Absen' }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-bold mb-2">Presensi</h2>
                     <div class="mb-3" id="map" wire:ignore></div>
                     <form class="flex justify-between" method="POST" wire:submit='store'>
                         <button type="button" onclick="tagLocation()" class="px-4 py-2 bg-blue-500 text-white rounded hover:cursor-pointer hover:bg-blue-700 transition">Tag Location</button>
                         @if ($insideRadius)
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:cursor-pointer hover:bg-green-700 transition">Kirim Presensi</button>   
                         @endif
                     </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let marker; 
    let office = [{{ $schedule->office->latitude }}, {{ $schedule->office->longitude }}];
    let radius = {{ $schedule->office->radius }};
    let isWfa = @json($schedule->iswfa);
    let map;
    let lat;
    let lng;
    let component;

    document.addEventListener('livewire:initialized', function () {
        component = @this;
        map = L.map('map').setView(office, 17);
    
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        }).addTo(map);
    
        var circle = L.circle(office, {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius
        }).addTo(map);
    });

    
    function tagLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                lat = position.coords.latitude;
                lng = position.coords.longitude;

                if (marker) {
                    map.removeLayer(marker);
                }
                
                marker = L.marker([lat, lng]).addTo(map);
                map.setView([lat, lng], 17);
                
                if (isWithinRadius(lat, lng, office, radius)) {
                    component.set('insideRadius', true);
                    component.set('latitude', lat);
                    component.set('longitude', lng);
                } else {
                    if (isWfa) {
                        component.set('insideRadius', true);
                        component.set('latitude', lat);
                        component.set('longitude', lng);
                    } else {
                        alert("Anda tidak berada dalam radius kantor. Presensi gagal dikirim!");
                    }
                }
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }

    }

    function isWithinRadius(lat, lng, center, radius) {
        let distance = map.distance([lat, lng], center);
        return distance <= radius;
    }
</script>