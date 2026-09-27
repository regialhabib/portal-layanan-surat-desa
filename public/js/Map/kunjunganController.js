// assets/js/map/controller.js
import { initMap } from "./init.js";
import { fetchKunjunganPelanggan } from "../Data/pelanggan.js";
import { addMarkersBatch } from "./markers.js";
import { showLoader, hideLoader, updateProgress } from "../UI/loader.js";
import { fetchKunjunganPelangganById } from "../Data/pelanggan.js";
import { getRole } from "../Config/base-url.js";
import { delay } from "../Helpers/async.js";
import { showSimpleErrorToast } from "../UI/toast.js";
import { initPelangganFilter } from "../UI/filter.js";
import { initSearch } from "../UI/searchOld.js";
import { bindPopupEvents } from "../UI/popup.js";
import { initRouting } from "./routing.js";
import { addMyLocationControl } from "../UI/showLocation.js";
import { addClearRouteControl } from "./Routing/routingController.js";
import { rencanakanRutePetugas } from "./perencanaanRute.js";
let map;
let pelanggan

export async function loadMapPage() {
    try {
        showLoader();

        updateProgress(10, "Menginisialisasi peta...");
        map = initMap();

        updateProgress(30, "Mengambil data pelanggan...");
        if (getRole() === "petugas") {
             pelanggan = await fetchKunjunganPelanggan();
        } else {
            pelanggan = await fetchKunjunganPelangganById();
        }

        updateProgress(50, "Menyiapkan marker...");
        await delay(200);
        await rencanakanRutePetugas(pelanggan);
        // await addMarkersBatch(map, pelanggan);
        initPelangganFilter();

        bindPopupEvents(map);

        updateProgress(100, "Semua data berhasil dimuat");

        await delay(400);

        initRouting(map);

        initSearch();

        addMyLocationControl(map);

        addClearRouteControl(map);
    } catch (err) {
        console.error(err);
        updateProgress(100, "Terjadi kesalahan saat memuat data");
        showSimpleErrorToast("Belum ada data tugas kunjungan");
    } finally {
        hideLoader();
    }
}

export { map };
