<div class="modal-overlay" id="loginModal">
    <div class="modal">
        <div class="modal-header">
            <h2>Welcome Back</h2>
            <button class="modal-close" onclick="closeLogin()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="text-center mb-6">
                <img src="{{ asset('images/kuet-logo.png') }}" alt="KUET Logo" class="h-16 mx-auto mb-4">
                <p class="text-slate-500">Sign in to your KUET EMS account</p>
            </div>
            <form>
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-input" placeholder="your.email@kuet.ac.bd">
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-input" placeholder="Enter your password">
                </div>
                <div class="flex justify-between items-center mb-6">
                    <label class="flex items-center gap-2 text-sm text-slate-500 cursor-pointer">
                        <input type="checkbox" class="accent-kuet-600"> Remember me
                    </label>
                    <a href="#" class="text-sm text-kuet-700 font-medium hover:underline">Forgot Password?</a>
                </div>
                <button type="button" class="btn btn-primary w-full">Sign In</button>
            </form>
            <div class="text-center mt-6 pt-6 border-t border-slate-100">
                <p class="text-sm text-slate-500">Don't have an account? <a href="#" class="text-kuet-700 font-medium hover:underline">Contact Admin</a></p>
            </div>
        </div>
    </div>
</div>