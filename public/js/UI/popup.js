import { highlightMarker } from "../Map/markers.js";
import { startNavigation } from "../Map/Routing/routingController.js";
import { getRole } from "../Config/base-url.js";
import { getBaseUrl } from "../Config/base-url.js";

let role = getRole();
let hidden = role !== "petugas" ? "d-none" : "";

export function renderPopupHTML(p) {
    let status = p.status_kunjungan === "sudah_dikunjungi" ? "d-none" : "";
    return `
            <div class="dark-card">
    <div class="dark-card-header">
        <h3>${p.nama}</h3>
    
    </div>

    <div class="dark-card-body">
        <div class="info-row">
        <span class="label">Golongan Tarif</span>
        <span class="value">${p.golongan_tarif}</span>
        </div>

        <div class="info-row">
        <span class="label">Daya</span>
        <span class="value">${p.daya} VA</span>
        </div>

        <div class="address">
        📍 ${p.alamat}
        </div>
    </div>

    <div class="dark-card-footer ${hidden} gap-3">
        <button class="btn primary btn-navigate mb-2">  <span class="label">Rute</span>
        <span class="spinner d-none spinner-border spinner-border-sm"></span></button>
        <button class="btn btn-success ${status}" onclick="handleSelesaiKunjungan(${p.id_detail_tugas}, this)">
      <span class="label">SelesaI Kunjungan</span>
      <span class="spinner d-none spinner-border spinner-border-sm"></span>
    </button>
    </div>
    </div>
        `;
}
// Kita tempelkan fungsi ke window agar bisa diakses oleh onclick inline
window.handleSelesaiKunjungan = async function (idDetail, btnElement) {
    const result = await Swal.fire({
        title: "Konfirmasi Selesai",
        text: "Pastikan Anda sudah berada di lokasi pelanggan",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#198754",
        cancelButtonText: "Batal",
        confirmButtonText: "Ya, Selesai",
    });

    if (result.isConfirmed) {
        // 1. Tampilkan Spinner
        const label = btnElement.querySelector(".label");
        const spinner = btnElement.querySelector(".spinner");
        label.classList.add("d-none");
        spinner.classList.remove("d-none");
        btnElement.disabled = true;

        try {
            const response = await fetch(
                `/api/kunjungan/update-status/${idDetail}`,
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                    },
                },
            );

            const data = await response.json();

            if (data.success) {
                Swal.fire(
                    "Berhasil!",
                    "Data kunjungan telah disimpan.",
                    "success",
                ).then(() => location.reload()); // Refresh untuk update peta
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            Swal.fire("Error!", error.message, "error");
            label.classList.remove("d-none");
            spinner.classList.add("d-none");
            btnElement.disabled = false;
        }
    }
};
function setRoutingLoading(btn, loading) {
    btn.querySelector(".label").style.display = loading ? "none" : "inline";
    btn.querySelector(".spinner").classList.toggle("d-none", !loading);
    btn.disabled = loading;
}

export function bindPopupEvents(map) {
    map.on("popupopen", (e) => {
        const popupEl = e.popup.getElement();
        if (!popupEl) return;

        const marker = e.popup._source;
        if (!marker) return;

        // tombol navigasi
        const btnNav = popupEl.querySelector(".btn-navigate");
        if (btnNav) {
            btnNav.onclick = async () => {
                setRoutingLoading(btnNav, true);

                try {
                    await startNavigation(map, marker);
                } finally {
                    setRoutingLoading(btnNav, false);
                }
            };
        }

        // tombol highlight saja
        const btnHighlight = popupEl.querySelector(".btn-highlight");
        if (btnHighlight) {
            btnHighlight.addEventListener("click", () => {
                highlightMarker(marker);
            });
        }
    });
}
