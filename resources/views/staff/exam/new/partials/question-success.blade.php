<div class="container-fluid px-4">
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                            <i class="fas fa-check fa-2x"></i>
                        </div>
                    </div>
                    <h2 class="mb-3">Question Created Successfully!</h2>
                    <p class="text-muted mb-4">Your question has been added to the database and is pending approval.</p>
                    
                    <div class="d-flex justify-content-center gap-3">
                        <button hx-get="{{ route('staff.exam.create-question') }}"
                                hx-target="closest div.container-fluid"
                                hx-swap="outerHTML"
                                class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add Another Question
                        </button>
                        <a href="{{ route('staff.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-home me-2"></i>Go to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
