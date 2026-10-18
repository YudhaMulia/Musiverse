// Ikon mata: tampilkan / sembunyikan kata sandi di semua kolom password pada halaman auth & profil
document.addEventListener('DOMContentLoaded', () => {
    const ikon = (isi, kelas) =>
        `<svg class="${kelas}" viewBox="0 0 24 24" aria-hidden="true">${isi}</svg>`;

    const MATA = ikon(
        '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
        'mata-buka'
    );
    const MATA_CORET = ikon(
        '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>',
        'mata-tutup'
    );

    document.querySelectorAll('.auth__field input[type="password"]').forEach((input) => {
        // bungkus input supaya tombol bisa diletakkan di dalam kolom
        const bungkus = document.createElement('div');
        bungkus.className = 'auth__kata';
        input.parentNode.insertBefore(bungkus, input);
        bungkus.appendChild(input);

        const tombol = document.createElement('button');
        tombol.type = 'button';
        tombol.className = 'auth__mata';
        tombol.setAttribute('aria-label', 'Tampilkan kata sandi');
        tombol.setAttribute('aria-pressed', 'false');
        tombol.innerHTML = MATA + MATA_CORET;
        bungkus.appendChild(tombol);

        tombol.addEventListener('click', () => {
            const tampil = input.type === 'password';
            input.type = tampil ? 'text' : 'password';
            tombol.classList.toggle('is-tampil', tampil);
            tombol.setAttribute('aria-pressed', String(tampil));
            tombol.setAttribute('aria-label', tampil ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
            input.focus();
        });
    });
});