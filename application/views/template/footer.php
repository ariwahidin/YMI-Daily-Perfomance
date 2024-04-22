</div>
<!-- container-fluid -->
</div>
<!-- End Page-content -->

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <!-- <script>
                    document.write(new Date().getFullYear())
                </script>  -->
                PT. Puninar Yusen Logistics Indonesia
            </div>
            <!-- <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by Themesbrand
                </div>
            </div> -->
        </div>
    </div>
</footer>

<!-- JAVASCRIPT -->
<script src="<?= base_url('jar/html/default/') ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('jar/html/default/') ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url('jar/html/default/') ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?= base_url('jar/html/default/') ?>assets/libs/feather-icons/feather.min.js"></script>
<script src="<?= base_url('jar/html/default/') ?>assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="<?= base_url('jar/html/default/') ?>assets/js/plugins.js"></script>

<!-- apexcharts -->
<script src="<?= base_url('jar/html/default/') ?>assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Vector map-->
<script src="<?= base_url('jar/html/default/') ?>assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
<script src="<?= base_url('jar/html/default/') ?>assets/libs/jsvectormap/maps/world-merc.js"></script>

<!-- projects js -->
<script src="<?= base_url('jar/html/default/') ?>assets/js/pages/dashboard-projects.init.js"></script>
<!-- Dashboard init -->
<script src="<?= base_url('jar/html/default/') ?>assets/js/pages/dashboard-job.init.js"></script>
<!-- App js -->
<script src="<?= base_url('jar/html/default/') ?>assets/js/app.js"></script>




<!-- My JS -->
<script>
    async function logout() {
        try {
            const response = await fetch("<?= base_url('auth/logout') ?>", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const responseData = await response.json();
                if (responseData.success === true) {
                    window.location.href = "<?= base_url('auth/login') ?>"; // Ganti dengan URL halaman login yang sesuai
                } else {
                    console.error('Logout gagal:', responseData.message);
                }
            } else {
                console.error('Logout gagal:', response.status);
            }
        } catch (error) {
            console.error('Terjadi kesalahan:', error);
        }
    }
    const logoutLink = document.getElementById('logoutLink');
    logoutLink.addEventListener('click', (event) => {
        event.preventDefault(); // Mencegah navigasi ke "#" (atau URL kosong) jika elemen <a> ditekan
        logout(); // Panggil fungsi logout saat tautan Logout diklik
    });

    setTimeout(stopLoading, 1000);
</script>
</body>



</html>