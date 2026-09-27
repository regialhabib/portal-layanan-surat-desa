// assets/js/data/pelanggan.service.js
import { CONFIG } from "../Config/mapConfig.js";

export async function fetchPelanggan() {
    console.log(CONFIG.apiBase);

    const res = await fetch(`${CONFIG.apiBase}/pelanggans`);
    const json = await res.json();

    if (!json.success) {
        throw new Error(json.message || "Gagal mengambil data pelanggan");
    }

    return json.data;
}

export async function fetchKunjunganPelanggan() {
    const res = await fetch(`/tugas-kunjungan/pelanggans`);
    const json = await res.json();

    if (!json.success) {
        throw new Error(
            json.message || "Gagal mengambil data kunjungan pelanggan",
        );
    }

    return json.data;
}

export async function fetchKunjunganPelangganById() {
    const segments = window.location.pathname.split("/");
    const id = segments.pop();

    const res = await fetch(`/tugas-kunjungan/pelanggans/${id}`);
    const json = await res.json();

    if (!json.success) {
        throw new Error(json.message || "Gagal mengambil data kunjungan pelanggan");
    }
    console.log(json.data);
    return json.data;
}
