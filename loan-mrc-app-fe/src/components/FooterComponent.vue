<template>
    <div>
        <div class="container">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                <div class="col-md-6 d-flex align-items-center">
                <a href="/" class="mb-3 mb-md-0 text-muted text-decoration-none lh-1 d-flex align-items-baseline">
                    <div class="me-1">
                        &copy; {{ year }}
                    </div>
                    <span class="text-muted me-1 text-lowercase">arifinhabibi_</span>
                </a>
                </div>

                <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-muted" href="#"><i class="bi bi-tiktok"></i></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><i class="bi bi-linkedin"></i></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><i class="bi bi-github"></i></a></li>
                </ul>
            </footer>
        </div>
    </div>
</template>


<script>
    export default {
        name: 'FooterComponent',
        data() {
            return {
                year: new Date().getFullYear()
            }
        },
    }
</script>