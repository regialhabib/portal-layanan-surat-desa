import { renderPopupHTML } from "../UI/popup.js";
import { map } from "./kunjunganController.js";
import { showMyLocation } from "./Location/locationService.js";
import { lokasiSaya } from "./Location/locationService.js";
let lokasiPetugas;
let markersLayer = L.layerGroup();
let markers = [];
let activeHighlightRing = null;

// Gunakan try-catch karena top-level await bisa berisiko

export async function rencanakanRutePetugas(pelanggan) {
    navigator.geolocation.getCurrentPosition(
        function (pos) {
            lokasiPetugas = {
                lat: pos.coords.latitude,
                lng: pos.coords.longitude,
            };
            rencanakanRute(pelanggan);
        },
        (err) => {
            console.error("Gagal mengambil lokasi petugas", err);
        },
    );
}

function rencanakanRute(pelanggan) {
    // OSRM Trip API butuh format lng,lat
    let koordinat = [];

    // 1. Tambahkan posisi petugas sebagai titik awal
    koordinat.push(`${lokasiPetugas.lng},${lokasiPetugas.lat}`);

    // 2. Tambahkan semua pelanggan
    pelanggan.forEach(function (p) {
        // Pastikan menggunakan properti yang benar: p.longitude dan p.latitude
        koordinat.push(`${p.longitude},${p.latitude}`);
    });

    let koordinatString = koordinat.join(";");

    // Gunakan URL Trip Service untuk optimalan rute
    let url = `https://router.project-osrm.org/trip/v1/driving/${koordinatString}?roundtrip=false&source=first&destination=last&overview=full&geometries=geojson`;

    fetch(url)
        .then((res) => res.json())
        .then((data) => {
            if (data.code === "Ok") {
                tampilkanRuteOSRM(data, pelanggan);
            } else {
                console.error("OSRM Error:", data.message);
            }
        });
}

function tampilkanRuteOSRM(data, dataPelangganAsli) {
    // 1. Gambar Garis Biru Rute
    let route = data.trips[0].geometry;
    L.geoJSON(route, {
        style: { color: "#3051d3", weight: 5, opacity: 0.7 },
    }).addTo(map);

    // 2. Tampilkan Marker Urutan

    tampilkanUrutanMarker(data.waypoints, dataPelangganAsli);
    markersLayer.addTo(map);
}

function tampilkanUrutanMarker(waypoints, dataPelangganAsli) {
    waypoints.forEach(function (wp, index) {
        // Index 0 adalah lokasi petugas (Start), kita lewati atau beri icon khusus
        if (wp.waypoint_index === 0) {
            lokasiSaya(map);
            // L.marker([wp.location[1], wp.location[0]])
            //     .addTo(map)
            //     .bindPopup("Posisi Anda (Start)");
            return;
        }

        // Cari data pelanggan asli berdasarkan waypoint_index
        // OSRM memberikan waypoint_index sesuai urutan input di URL
        // Karena input 0 adalah petugas, maka pelanggan 1 adalah index 1, dst.
        let dataP = dataPelangganAsli[wp.waypoint_index - 1];

        let lat = wp.location[1];
        let lng = wp.location[0];

        // Nomor urutan yang sudah dioptimasi oleh OSRM (trips[0].legs)
        // Namun cara termudah adalah menggunakan urutan kunjungan sebenarnya
        let nomorKunjungan = wp.waypoint_index;
        let warnaMarker = dataP.status_kunjungan === "sudah_dikunjungi" ? "#28a745" : "#3051d3";
        let icon = L.divIcon({
            className: "custom-marker",
            html: `<div style="
                background:${warnaMarker};
                color:white;
                border-radius:50%;
                width:32px;
                height:32px;
                text-align:center;
                line-height:32px;
                font-weight:bold;
                border: 2px solid white;
                box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            ">${nomorKunjungan}</div>`,
            iconSize: [32, 32],
            iconAnchor: [16, 16],
        });

        const marker = L.marker([lat, lng], { icon: icon }).bindPopup(
            renderPopupHTML(dataP),
        );
        marker.data = dataP;



        markers.push(marker);
        // Tambahkan ke group, bukan langsung ke map
        markersLayer.addLayer(marker);
        // L.marker([lat, lng], { icon: icon })
        //     .addTo(map)
        //     .bindPopup(renderPopupHTML(dataP));
    });
}

export function highlightMarker(marker) {
    if (!marker) return;

    const map = marker._map;
    if (!map) return;

    const latlng = marker.getLatLng();

    // buka popup marker
    marker.openPopup();

    // hapus ring lama (jika ada)
    if (activeHighlightRing) {
        map.removeLayer(activeHighlightRing);
        activeHighlightRing = null;
    }

    // buat ring highlight
    activeHighlightRing = L.circleMarker(latlng, {
        radius: 18,
        color: "#0d6efd",
        weight: 3,
        fill: false,
        opacity: 1,
    }).addTo(map);

    // auto remove setelah 2 detik
    setTimeout(() => {
        if (activeHighlightRing) {
            map.removeLayer(activeHighlightRing);
            activeHighlightRing = null;
        }
    }, 2000);
}

export function getAllMarkers() {
    return markers;
}
