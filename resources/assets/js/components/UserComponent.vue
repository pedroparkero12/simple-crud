<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>First</th>
                            <th>Last</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users">
                        <td>{{user.id}}</td>
                        <td>{{user.username}}</td>
                        <td>{{user.firstname}}</td>
                        <td>{{user.lastname}}</td>
                        <td><a href="#" @click="showUserModal('Edit',user)">Edit</a> / <a href="#" @click="confirmDelete(user)">Delete</a></td>
                    </tr>
                    </tbody>
                </table>
                <button class="btn btn-default"  @click="showUserModal('Add')">Add New User</button>
            </div>
        </div>
        <div class="modal fade" id="user_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <form id="userForm" class="needs-validation" novalidate @submit="checkForm" v-bind:class="{'was-validated': hasError}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                {{modalType}} User
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label>First name</label>
                                <input type="text" id="name" v-model="firstname" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Last name</label>
                                <input type="text" id="name" v-model="lastname" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" id="name" v-model="username" class="form-control" required>
                            </div>
                        </div>

                        <!-- Modal Actions -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" :value="modalType">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
        
</template>

<script>
    export default {
        data() {
			return {
                users: [],
                firstname:'',
                lastname:'',
                username:'',
                errors:[],
                modalType:'Add',
                hasError:false,
            }
        },
        ready(){
            this.prepareComponent();
        },
        mounted(){
            this.prepareComponent();
        },
        methods: {
            prepareComponent() {
               this.getUsers();
            },
            getUsers(){
                axios.get(`api/users`)
                .then((response) => {
                    this.users = response.data;
                });
            },
            clearFields(){
                this.id = '';
                this.firstname = '';
                this.lastname = '';
                this.username = '';
                this.hasError = false;
            },
            showUserModal(modalType,data){
                if(modalType=='Edit'){
                    this.firstname = data.firstname;
                    this.lastname = data.lastname;
                    this.username = data.username;
                    this.id = data.id;
                }

                this.modalType = modalType;
                $('#user_modal').modal('show');
               
            },
            checkForm(e){
                e.preventDefault();
                
                if (this.firstname && this.lastname && this.username) {
                   this.addUser();
                }
                
                this.errors = [];
                
                if (!this.firstname) {
                    this.errors.push('First name is required.');
                }
                if (!this.lastname) {
                    this.errors.push('Last name is required.');
                }
                if (!this.username) {
                    this.errors.push('Username is required.');
                }
                if(this.errors.length!=0){
                   this.hasError=true;
                   this.$swal("Error!", this.getErrors(this.errors), "error");
                    return false;
                }

            },
            addUser(){
                let data = {'firstname':this.firstname,'lastname':this.lastname,'username':this.username};
                //add user
                if(this.modalType=='Add'){
                    axios.post(`/api/users`,data)
                    .then((response) => { 
                        console.log(response.data);
                        if(response.data.errors!=undefined){
                            this.$swal("Error!", this.getBackError(response.data.errors), "error");
                        }
                        else{
                            $('#user_modal').modal('hide');
                            this.clearFields();
                            this.getUsers();
                        }
                    
                    })   
                }
                //edit user
                if(this.modalType=='Edit'){
                    axios.put(`/api/users/${this.id}`,data)
                    .then((response) => { 
                        console.log(response.data);
                        if(response.data.errors!=undefined){
                            this.$swal("Error!", this.getBackError(response.data.errors), "error");
                        }
                        else{
                            $('#user_modal').modal('hide');
                            this.clearFields();
                            this.getUsers();
                        }
                    
                    })   
                }
             
            },
            getErrors(errors){
                let list='';
                for(let x = 0; x<errors.length; x++){
                    if(x==errors.length-1) list+=errors[x];
                    else list+=errors[x]+', ';
                }
                return list;
            },
            getBackError(data){
                let list='';
                let x=0;
                for (let key in data) {
                   list+=data[key][0]+' ';
                }
                return list;

            },
            //delete users
            confirmDelete(data){
                this.$swal({
                    title: 'Delete username '+ data.username +'?',
                    text: 'You can\'t revert your action',
                    icon: "warning",
                    closeOnClickOutside: false,
                    dangerMode: true,
                    buttons: ["No!", "Yes, delete it!"],
                }).then((confirm)=>{
                    if(confirm){
                        axios.delete(`/api/users/${data.id}`,{})
                        .then((response) => { 
                            this.$swal('Deleted', 'You successfully deleted username '+data.username+'.', 'success');
                            this.getUsers();
                        })   
                    }
                });

            }
            
		}
    }
</script>
