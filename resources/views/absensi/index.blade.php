@extends('layouts.main')

@section('title', 'Absensi')

@section('content')
<h1 class="text-2xl font-bold">Absensi</h1>
<div class="filter-container">
    <input type="text" id="filter-nama" oninput="fetchData(1)" placeholder="Cari Nama">
    <select name="jurusan" id="filter-jurusan" onchange="updateKelas(); fetchData(1);">
        <option value="">Jurusan</option>
        <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
        <option value="Perhotelan">Perhotelan</option>
        <option value="Kuliner">Kuliner</option>
        <option value="Usaha Layanan Wisata">Usaha Layanan Wisata</option>
        <option value="Tata Busana">Tata Busana</option>
    </select>
    <select name="kelas" onchange="fetchData(1)" id="filter-kelas">
        <option value="">Pilih Kelas</option>
    </select>
    <input type="date" onchange="fetchData(1)" id="filter-tanggal">
    <select id="filter-status" onchange="fetchData(1)">
        <option value="">Status</option>
        <option value="Terlambat">Terlambat</option>
        <option value="Tepat Waktu">Tepat waktu</option>
    </select>
    <select id="filter-mood" onchange="fetchData(1)">
        <option value="">Pilih Mood</option>
        <option value="Senang">Senang</option>
        <option value="Sedih">Sedih</option>
        <option value="Biasa Saja">Biasa Saja</option>
    </select>
    <button onclick="resetData(1)" class="reset-btn">Reset</button>
    <button class="refresh-btn" onclick="showNotification('Data Terupdate!')">
        <i class="uil uil-refresh"></i>
    </button>
    <div id="data-container"></div>
</div>
<div id="notification-container" class="notification-container"></div>
<table id="absensi-table">
    <thead>
        <tr>
            <th>NISN</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Kelas</th>
            <th>Mood</th>
            <th>Catatan</th>
            <th>Status</th>
            <th>Waktu</th>
        </tr>
    </thead>
    <tbody id="absensi-body">
        <!-- Rows generated dynamically -->
    </tbody>
</table>
<div class="pagination" id="pagination"></div>
<script>
    let currentPage = 1;
    const limit = 25;

    document.addEventListener("DOMContentLoaded", function() {
        fetchData(currentPage);
        setInterval(() => fetchData(currentPage), 10000);
    });

    async function fetchData(page) {
        console.log('Fetching data...');
        currentPage = page;
        const filters = getFilters();

        const query = new URLSearchParams({
            page,
            limit,
            ...filters
        }).toString();
        const response = await fetch(`/api/absensi?${query}`);

        console.log(`/api/absensi?${query}`);

        const result = await response.json();

        console.log('Data dari server:', result);
        console.log('Hasil filter:', result.data);

        renderTable(result.data);
        setupPagination(result.total, result.limit);
    }

    function resetData(page) {

        clearKelas();

        document.getElementById('filter-nama').value = '';
        document.getElementById('filter-jurusan').value = '';
        document.getElementById('filter-kelas').value = '';
        document.getElementById('filter-status').value = '';
        document.getElementById('filter-mood').value = '';
        document.getElementById('filter-tanggal').value = '';

        fetchData(page);
    };


    function renderTable(data) {
        const tbody = document.getElementById("absensi-body");
        tbody.innerHTML = "";

        data.forEach(row => {
            const tr = document.createElement("tr");
            const status = (row.Status === "Tepat Waktu--") ? `<td>${row.Status}</td>` : `<td style="color: red;">${row.Status}</td>`;
            tr.innerHTML = `
            <td>${row.NISN}</td>
            <td>${row.Nama}</td>
            <td>${row.Jurusan}</td>
            <td>${row.Kelas}</td>
            <td>${row.Mood}</td>
            <td>${row.Catatan}</td>
            ` + status + `
            <td>${row.Waktu}</td>
        `;
            tbody.appendChild(tr);
        });
    }

    function setupPagination(total, limit) {
        const pagination = document.getElementById("pagination");
        const totalPages = Math.ceil(total / limit);
        pagination.innerHTML = Array.from({
            length: totalPages
        }, (_, i) => `
                <button onclick="changePage(${i + 1})" id="page-btn-${i + 1}">${i + 1}</button>
            `).join('');

    }

    function changePage(page) {
        fetchData(page)
        document.querySelectorAll('#pagination button').forEach(btn => {
            btn.classList.remove('active');
        });
        document.getElementById(`page-btn-${page}`).classList.add('active');
    }

    // blom tau buat apa
    function getFilters() {
        const filters = {
            nama: document.getElementById('filter-nama').value,
            jurusan: document.getElementById('filter-jurusan').value,
            kelas: document.getElementById('filter-kelas').value,
            tanggal: document.getElementById('filter-tanggal').value,
            status: document.getElementById('filter-status').value,
            mood: document.getElementById('filter-mood').value,
        };

        if (filters.nama.trim() === "") delete filters.nama;
        if (filters.jurusan === "") delete filters.jurusan;
        if (filters.kelas === "") delete filters.kelas;
        if (filters.status === "") delete filters.status;
        if (filters.tanggal === "") delete filters.tanggal;
        if (filters.mood === "") delete filters.mood;

        return filters;
    };

    function updateKelas() {
        var jurusan = document.getElementById("filter-jurusan").value;
        var kelasSelect = document.getElementById("filter-kelas");

        clearKelas();
        // Data kelas berdasarkan jurusan
        var kelasList = {
            "Rekayasa Perangkat Lunak": ["X RPL 1", "X RPL 2", "XI RPL 1", "XI RPL 2", "XII RPL 1", "XII RPL 2"],
            "Perhotelan": ["X PH 1", "X PH 2", "X PH 3", "XI PH 1", "XI PH 2", "XI PH 3", "XII PH 1", "XII PH 2", "XII PH 3"],
            "Kuliner": ["X KUL 1", "X KUL 2", "X KUL 3", "XI KUL 1", "XI KUL 2", "XI KUL 3", "XII KUL 1", "XII KUL 2", "XII KUL 3"],
            "Usaha Layanan Wisata": ["X ULW 1", "XI ULW 1", "XII ULW 1"],
            "Tata Busana": ["X TBS 1", "X TBS 2", "X TBS 3", "XI TBS 1", "XI TBS 2", "XI TBS 3", "XII TBS 1", "XII TBS 2", "XII TBS 3"],

        };

        // Tambahkan opsi kelas yang sesuai dengan jurusan yang dipilih
        if (jurusan in kelasList) {
            kelasList[jurusan].forEach(function(kelas) {
                var option = document.createElement("option");
                option.value = kelas;
                option.textContent = kelas;
                kelasSelect.appendChild(option);
            });
        }
    }

    function clearKelas() {
        var kelasSelect = document.getElementById("filter-kelas");
        kelasSelect.innerHTML = '<option value="">Pilih Kelas</option>';
    }

    function updateClock() {
        let now = moment().format('dddd, DD MMMM YYYY | hh:mm:ss A');
        document.getElementById('clock').innerText = now;
    }

    function showNotification(message) {
        const container = document.getElementById('notification-container');
        if (container.children.length >= 3) {
            container.removeChild(container.firstChild);
        }

        const notification = document.createElement('div');
        notification.classList.add('notification', 'show');
        notification.textContent = message;

        container.appendChild(notification);

        fetchData(1);

        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
</script>
@endsection