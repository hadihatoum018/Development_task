<template>
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Project</h3>
                        </div>
                        <div class="col text-right">
                            <router-link to="/project" class="btn btn-sm btn-primary">See all</router-link>
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
                        </tr>
                        </thead>
                        <tbody class="list" v-for="item in items" :key="item.name">
                            <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">
                                            {{ item.name }}
                                        </span>
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
</template>

<script>
export default {
    name: "ProductTable",
    data(){
        return{
            items:{},
            dataNotFound : false
        }
    },
    methods:{
        getProject(){
            let Loading = this.block("projectLoading")
            this.axios.get("/api/v1/projects")
                .then(response =>{
                    this.items = response.data.data;
                    console.log(response.data.data)
                    Loading.close()
                    this.dataNotFound = false
                })
                .catch(error =>{
                    this.items = null
                    this.dataNotFound = true
                    console.log(error.response.data)
                    Loading.close()
                })
        }
    },
    mounted() {
        this.getProject()
    }
}
</script>

