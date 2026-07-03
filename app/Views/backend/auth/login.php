<div class="w-full max-w-md mx-auto">
    <!-- Logo & Title -->
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
            <i class="fas fa-lock text-white text-2xl"></i>
        </div>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Admin Panel</h1>
        <p class="text-gray-500 text-sm mt-1">BPRS Bangka Belitung</p>
    </div>

    <!-- Flash Error -->
    <?php if ($flash_error ?? null): ?>
    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-center gap-2">
        <i class="fas fa-exclamation-circle flex-shrink-0"></i>
        <?= e($flash_error) ?>
    </div>
    <?php endif; ?>

    <!-- Flash Success -->
    <?php if ($flash_success ?? null): ?>
    <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
        <i class="fas fa-check-circle flex-shrink-0"></i>
        <?= e($flash_success) ?>
    </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form method="POST" action="/admin/login" data-validate>
            <?= $csrf ?>

            <!-- Username -->
            <div class="mb-5">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1.5">Username / Email</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="username" name="username" required
                           value="<?= e($_POST['username'] ?? '') ?>"
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-shadow"
                           placeholder="Masukkan username atau email"
                           autocomplete="username">
                </div>
            </div>

            <!-- Password -->
            <div class="mb-6" x-data="{ show: false }">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input :type="show ? 'text' : 'password'" id="password" name="password" required
                           class="w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-shadow"
                           placeholder="Masukkan password"
                           autocomplete="current-password">
                    <button type="button" @click="show=!show"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                            :title="show ? 'Sembunyikan password' : 'Tampilkan password'">
                        <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2.5 rounded-lg transition-colors text-sm flex items-center justify-center gap-2">
                <i class="fas fa-sign-in-alt"></i>Masuk
            </button>
        </form>
    </div>

    <!-- Footer -->
    <p class="text-center text-xs text-gray-400 mt-6">
        &copy; <?= date('Y') ?> BPRS Bangka Belitung. Berizin &amp; Diawasi OJK.
    </p>
</div>

<script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js"></script>
<script src="/assets/js/main.js"></script>
