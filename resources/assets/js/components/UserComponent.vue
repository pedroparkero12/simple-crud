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
                    <tr>
                        <td>1</td>
                        <td>pedro</td>
                        <td>Pedro</td>
                        <td>Parkero</td>
                        <td>Edit / Delete</td>
                    </tr>
                    </tbody>
                </table>
                <button class="btn btn-default">Add New User</button>
            </div>
        </div>
        <div class="modal fade" id="write_comment" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Write a comment
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="name" v-model="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Comment</label>
                            <input type="text" id="content" v-model="content" class="form-control">
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" @click="addComment">Reply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
</template>

<script>
    export default {
        data() {
			return {
                root_comments: [],
                comments: [],
                parent_id:null,
                name:'',
                content:'',
                errors:[]
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
               
            },
            getComments(){
                // axios.get(`/comments`+`?no_parent=""`)
                // .then((response) => {
                //     this.root_comments = response.data;
                // });
                // axios.get(`/comments`)
                // .then((response) => {
                //     this.comments = response.data;
                // });
            },
            clearFields(){
                this.name = '';
                this.content = '';
            },
            showCommentModal(parent_id){
                if(parent_id==undefined) this.parent_id=null;
                else this.parent_id = parent_id
                $('#write_comment').modal('show');
            },
            checkForm(){
                if (this.name && this.content) {
                    return true;
                }
                
                this.errors = [];
                
                if (!this.name) {
                    this.errors.push('Name is required.');
                }
                if (!this.content) {
                    this.errors.push('Comment is required.');
                }
                
            },
            addComment(){
                if(this.checkForm()){
                    var data = {'post_id':1,'name':this.name,'content':this.content,'parent_id':this.parent_id};

                    axios.post(`/comments`,data)
                    .then((response) => { 
                        $('#write_comment').modal('hide');
                        this.clearFields();
                        this.getComments();
                    })
                }
                else{
                    alert(this.errors);
                }
            }
            
		}
    }
</script>
