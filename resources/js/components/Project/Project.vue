<template>
    <div>
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Project</h6>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <a href="#" class="btn btn-sm btn-neutral" @click="addProjectModel=!addProjectModel">New</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col">
                    <div class="card" id="deleteLoading">
                        <!-- Card header -->
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">Project</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Light table -->
                        <div class="table-responsive" id="projectLoading">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort">Project</th>
                                    <th scope="col" class="sort">Budget</th>
                                    <th scope="col" class="sort">Create At</th>
                                    <th scope="col" class="sort">Action</th>
                                </tr>
                                </thead>
                                <tbody class="list" v-for="item in items" :key="item.id">
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{ item.name }}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget">
                                        {{ item.budget }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="completion mr-2">{{ new Date(item.created_at).toLocaleString() }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: inline-flex">
                                            <div>
                                                <button class="btn btn-primary btn-sm" @click="editBtn(item.id)">
                                                    <i class="far fa-edit"></i>
                                                    <span><strong>Edit</strong></span>
                                                </button>
                                                <button href="#" class="btn btn-danger btn-sm"
                                                        @click="deleteBtn(item.id)">
                                                    <i class="fas fa-trash-alt"></i>
                                                    <span><strong>Delete</strong></span>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-if="dataNotFound">
                                <tr class="text-center">
                                    <td colspan="10">No Data Display</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <vs-dialog v-model="addProjectModel" prevent-close blur>
            <template #header>
                <h4 class="not-margin">
                    Add New <b>Project</b>
                </h4>
            </template>
            <form v-on:submit.prevent="addProject()" id="addProjectForm" ref="resetForm">
                <div class="form-group">
                    <label class="form-control-label">Name Of Project</label>
                    <input class="form-control" placeholder="Name" v-model="addPostData.name"/>
                </div>
                <div class="form-group mt--3">
                    <label class="form-control-label">Budget</label>
                    <input type="number" class="form-control" placeholder="Budget" v-model="addPostData.budget"/>
                </div>
                <div class="footer-dialog text-center">
                    <button class="btn btn-primary" type="submit">Add New Project</button>
                </div>
            </form>
        </vs-dialog>

        <vs-dialog v-model="editProjectModel" prevent-close blur>
            <template #header>
                <h4 class="not-margin">
                    Add New <b>Project</b>
                </h4>
            </template>
            <form v-on:submit.prevent="updateProject()" id="editProjectForm">
                <div class="form-group">
                    <label class="form-control-label">Name Of Project</label>
                    <input class="form-control" placeholder="Name" v-model="editPostData.name"/>
                </div>
                <div class="form-group mt--3">
                    <label class="form-control-label">Budget</label>
                    <input type="number" class="form-control" placeholder="Budget" v-model="editPostData.budget"/>
                </div>
                <div class="footer-dialog text-center">
                    <button class="btn btn-primary" type="submit">Update Project</button>
                </div>
            </form>
        </vs-dialog>

        <vs-dialog width="550px" not-center v-model="deleteDialog">
            <template #header>
                <h4 class="not-margin">
                    <b>Are you sure?</b>
                </h4>
            </template>
            <div class="con-content">
                <p>Are you sure you want to Delete?</p>

            </div>
            <template #footer>
                <div class="con-footer">
                    <button class="btn btn-primary" @click="deleteProject()">
                        Ok
                    </button>
                    <button class="btn btn-light" @click="deleteDialog=false">
                        Cancel
                    </button>
                </div>
            </template>
        </vs-dialog>
    </div>
</template>

<script>
export default {
    name: "Dashboard",
    data() {
        return {
            addPostData: {
                name: null,
                budget: null,
            },
            editPostData: {
                id: null,
                name: null,
                budget: null,
            },
            deletePostData: {
                id: null
            },
            items: {},

            addProjectModel: false,
            editProjectModel: false,
            activeTooltip1: false,
            deleteDialog: false,
            dataNotFound : false,
        }
    },
    methods: {
        getProject() {
            let loading = this.block("projectLoading");
            this.axios.get("/api/v1/projects")
                .then(response => {
                    this.items = response.data.data;
                    console.log(response.data.data)
                    this.dataNotFound = false
                    loading.close()
                })
                .catch(error => {
                    this.items = null
                    this.dataNotFound = true
                    console.log(error.response.data)
                    loading.close()
                })
        },
        addProject() {
            let Loading = this.block("addProjectForm");
            this.axios.post('api/v1/add/project', this.addPostData)
                .then(response => {
                    if (response.data.status === true) {
                        this.$refs.resetForm.reset();
                        Loading.close();
                        this.addProjectModel = false;
                        this.getProject()
                    } else {
                        this.errorNotification(response.data.message)
                        Loading.close()
                    }
                })
                .catch(error => {
                    this.errorNotification(error.response.data.message)
                    Loading.close()
                });
        },
        updateProject() {
            let Loading = this.block("editProjectForm");
            this.axios.put("/api/v1/update/project", this.editPostData)
                .then(response => {
                    this.editProjectModel = false;
                    this.successNotification(response.data.message);
                    Loading.close()
                    this.getProject()
                })
                .catch(error => {
                    this.editProjectModel = false;
                    this.errorNotification(error.response.data.message);
                    Loading.close()
                });
        },
        deleteBtn(id) {
            if (id == '') {
                this.errorNotification("Something we Wrong..");
            }
            this.deleteDialog = true;
            this.deletePostData.id = id;
        },
        deleteProject() {
            let Loading = this.block("deleteLoading");
            this.axios.delete("/api/v1/delete/project/" + this.deletePostData.id)
                .then(response => {
                    if (response.data.status === true) {
                        this.deleteDialog = false;
                        this.successNotification(response.data.message)
                        this.getProject();
                        Loading.close();
                    } else {
                        this.deleteDialog = false;
                        this.errorNotification(response.data.message)
                        Loading.close();
                    }
                })
                .catch(error => {
                    this.deleteDialog = false;
                    Loading.close();
                    this.errorNotification(error.response.data.message)
                });
        },
        editBtn(id) {
            this.editPostData.id = id;
            this.editProjectModel = true;
            this.axios.get("/api/v1/get/project/" + id)
                .then(response => {
                    let item = response.data.data;
                    this.editPostData.name = item.name;
                    this.editPostData.budget = item.budget;
                })
                .catch(error => {
                    console.log(error.response.data)
                });
        },
    },
    mounted() {
        this.getProject()
    }
}
</script>
<style>
.btn i:not(:last-child), .btn svg:not(:last-child) {
    margin-right: unset;
}
</style>
