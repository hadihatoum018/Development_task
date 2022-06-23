<template>
    <div>
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-3">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Development Task</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt--6">
            <ProductTable></ProductTable>
        </div>
    </div>
</template>

<script>

import ProductTable from "./ProductTable";
export default {
    name: "Dashboard",
    components: {ProductTable},
}
</script>
