@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<div id="notification-container" class="notification-container"></div>

<h1 class="text-2xl font-bold">Selamat Datang di Dashboard</h1>
<div class="card-container">
    <div class="card terlambat" data-type="terlambat">
        <div class="text">
            <h4 class="info">Terlambat</h4>
            <h1 class="text-2xl font-bold">0 Siswa</h1>
        </div>
    </div>
    <div class="card mood-sad" data-type="sedih">
        <div class="text">
            <h4 class="info">Sedih</h4>
            <h1 class="text-2xl font-bold">0 Siswa</h1>
        </div>
    </div>
    <div class="card tidak-hadir" data-type="belum-hadir">
        <div class="text">
            <h4 class="info">Belum Absen</h4>
            <h1 class="text-2xl font-bold">0 dari 0 Siswa</h1>
        </div>
    </div>
</div>
<div id="dashboard-content" class="bg-white shadow-md rounded-lg overflow-hidden">
    <p class="text-center p-4">Pilih salah satu menu diatas untuk ditampilkan</p>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchData();
        setInterval(() => fetchData(), 10000);

        const dashboardContent = document.getElementById('dashboard-content');
        const cards = document.querySelectorAll('.card');

        let currentType = null;
        let dataRefreshInterval = null;

        cards.forEach(card => {
            card.addEventListener('click', () => {
                const type = card.getAttribute('data-type');
                currentType = type;

                if (dataRefreshInterval) {
                    clearInterval(dataRefreshInterval);
                }

                fetch(`/dashboard/load?type=${type}`)
                    .then(response => response.text())
                    .then(data => {
                        dashboardContent.innerHTML = data;

                        setTimeout(() => {
                            fetchTypeData(type);
                            // Set up new interval for this type
                            dataRefreshInterval = setInterval(() => fetchTypeData(type), 10000);
                        }, 0);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    });

    async function fetchData() {
        const response = await fetch(`/api/dashboard`);
        const result = await response.json();

        renderData(result);
        showNotification();
    }

    function renderData(data) {
        const terlambatCard = document.querySelector('.terlambat h1');
        const moodSadCard = document.querySelector('.mood-sad h1');
        const tidakHadirCard = document.querySelector('.tidak-hadir h1');

        terlambatCard.textContent = data.totalTerlambat + ' Siswa';
        moodSadCard.textContent = data.totalSedih + ' Siswa';
        tidakHadirCard.textContent = 1214 - data.totalHadir + ' dari 1214 Siswa';
    }

    async function fetchTypeData(type) {
        try {
            const response = await fetch(`/api/dashboard/${type}`);
            const result = await response.json();

            renderTable(result.data, type);
        } catch (error) {
            console.error('Error fetching type data:', error);
        }
    }

    function renderTable(data, type) {
        if (data.length === 0) {
            document.getElementById('dashboard-content').innerHTML = `<p class="text-center p-4">Tidak ada siswa yang ${(type != 'belum-hadir') ? type : 'belum hadir (Coming Soon)'}</p>`;
            return;
        }

        const tbody = document.getElementById("absensi-body");
        tbody.innerHTML = "";

        let no = 1;

        data.forEach(row => {
            const tr = document.createElement("tr");
            const status = (row.Status === "Tepat Waktu--") ? `<td>${row.Status}</td>` : `<td style="color: red;">${row.Status}</td>`;
            tr.innerHTML = `
            <td>${no++}</td>
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

    function showNotification() {
        const container = document.getElementById('notification-container');
        if (container.children.length >= 3) {
            container.removeChild(container.firstChild);
        }

        const notification = document.createElement('div');
        notification.classList.add('notification', 'show');
        notification.textContent = "Data berhasil diperbarui!";

        container.appendChild(notification);

        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
</script>
@endsection