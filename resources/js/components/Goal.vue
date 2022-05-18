<template>
    <!--Goalの作成ボタン部分-->
    <div class="container-fruid h-100 pt-5">
        <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#goalModal"></i><span class="align-middle">Create A New Goal</span>
        
        <!--（追加）タグ設定の見出し-->
        <i class="fa fa-plus align-middle pl-4 pr-1" data-toggle="modal" data-target="#tagModal"></i><span class="align-middle">Manage Tag</span>


        <!--Goal新規作成の画面-->
        <div class="modal fade" id="goalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!--modalのheader-->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Goal Name</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!--modalのbody-->
                    <div class="modal-body">
                        <input v-model="title" class="form-control">
                    </div>
                    <!--modalのfooter-->
                　　<div class="modal-footer">
                　　    <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="addNewGoal">Add</button>
                　　  <button type-"button" class="btn btn-primary">Save changes</button>
                　　</div>
                </div>
            </div>    
        </div>
        
        
        <!--（追加）タグの新規作成の画面-->
        <div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Tag Name</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input v-model="tagTitle" class="form-control">
                        <div v-for="(key, index) in tags" :key="index">
                            <button class="btn btn-secondary m-1" v-on:click="tagTitle = tags[index].title; tagId=tags[index].id" data-toggle="modal" data-target="#editTagModal" data-dismiss="modal">{{tags[index].title}}</button>
                            <button class="btn btn-danger m-1" v-on:click="deleteTag(tags[index].id)">✖</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" v-on:click="addNewTag">Add</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!--(追加)タグの編集画面-->
        <div class="modal fade" id="editTagModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Tag Name</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#tagModal" v-on:click="tagTitle=''; tagId=''">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input v-model="tagTitle" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="editTagTitle(tagId)">Edit</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#tagModal" v-on:click="tagTitle=''; tagId=''">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        <!--Goal編集の画面-->
        <div class="modal fade" id="editGoalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!--modalのheader部分-->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Goal Name</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!--modalのbody部分-->
                    <div class="modal-body">
                        <input v-model="title" class="form-control">
                    </div>
                    <!--modalのfooter-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="editGoalTitle">Edit</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!--Goal削除の画面-->
        <div class="modal fade" id="deleteGoalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Goal?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" v-on:click="deleteGoal">Delete</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!--作成したGoalのカードたち-->
        <div class="card-group h-100">
            <div v-for="(goal, key ,index) in goals" :key=index>
                <div class="card h-100 m-3" style="width: 24rem;">
                    <div class="d-flex justify-content-between">
                        <h3 class="ml-5 mt-2">{{goal.title}}</h3>
                        <div>
                            <i class="fa fa-plus p-2" data-toggle="modal" :data-target="'#todoModal' + goal.id"></i>
                            <div class="btn-group dropdown">
                                <i class="fa fa-ellipsis-v p-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="text-center" data-toggle="modal" data-target="#editGoalModal" v-on:click="title=goal.title; id=goal.id">Edit</div>
                                    <div class="text-danger text-center" data-toggle="modal" data-target="#deleteGoalModal" v-on:click="id = goal.id">Delete</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--ここの場所にTodos.vueをもってくる。また、propsでgoalIdを取ってこれるように設定-->
                    <goals-todos :goalId="goal.id"></goals-todos>
                </div>
            </div>
        </div>

    </div>
    

    
    
    
</template>
<script>
    import axios from "axios"
    import $ from "jquery"
    import Todos from "./Todos.vue";
    
    export default {
        // データの設定
        data: function(){
            return{
                id:"",
                title:"",
                tagId:"",
                tagTitle:"",
                goals:[],
                tags:[]
            }
        },
        // Todo.vueを使用する設定
        components: {
            'goals-todos' : Todos
        },
        
        // DOM生成直後に実行すること
        mounted:function(){
            this.getAllGoals();
            this.getAllTags();
        },
        
        // 実行すること
        methods: {
            getAllGoals:function(){
                axios.get("/goals").then((response)=>{
                    for(let i = 0; i < response.data.length; i++){
                        this.goals.push(response.data[i])
                    }
                },(error)=>{
                    console.log(error)
                })
            },
            
            addNewGoal: function(){
                axios.defaults.headers['X-CSRF-TOKEN']=$('meta[name=csrf-token]').attr('content');
                axios.defaults.headers['content-type']= 'application/json';
                axios.post("/goals", {title: this.title}).then((response)=>{
                    this.goals.length = 0;
                    for(let i = 0; i< response.data.length; i++){
                        this.goals.push(response.data[i])
                    }
                },(error)=>{
                    console.log(error)
                })
                this.title = ""
            },
            
            editGoalTitle: function(){
                axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
                axios.defaults.headers['content-type'] = 'application/json';
                axios.post(`/goals/${this.id}`, {title: this.title, _method:'patch'}).then((response)=>{
                    this.goals.length = 0;
                    for(let i = 0; i < response.data.length; i++){
                        this.goals.push(response.data[i])
                    }
                },(error)=>{
                    console.log(error)
                })
                this.title = ""
            },
            
            deleteGoal: function(){
                axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
                axios.defaults.headers['content-type'] = 'application/json';
                console.log(this.id)
                axios.post(`/goals/${this.id}`, {_method: 'delete'}).then((response)=>{
                    this.goals = response.data;
                },(error)=>{
                    console.log(error)
                })
                this.id=""
            },
            
            // タグのアクション
            getAllTags: function(){
                axios.get("/tags").then((response)=>{
                    console.log(response)
                    for(let i = 0; i < response.data.length; i++){
                        this.tags.push(response.data[i])
                        console.log(this.tags[i])
                    }
                    console.log(this.tags)
                },(error)=>{
                    console.log(error)
                })
            },
            addNewTag: function(){
                axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
                axios.defaults.headers['content-type'] = 'application/json';
                axios.post("/tags", {title: this.tagTitle}).then((response)=>{
                    this.tags.length= 0;
                    for(let i = 0; i < response.data.length; i++){
                        this.tags.push(response.data[i])
                    }
                },(error)=>{
                    console.log(error)
                })
                this.tagTitle = ""
            },
            editTagTitle: function(id){
                axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
                axios.defaults.headers['content-type'] = 'application/json';
                axios.post(`/tags/${id}`, {title:this.tagTitle, _method:'patch'}).then((response)=>{
                    this.tags.length=0;
                    for(let i = 0; i < response.data.length; i++){
                        this.tags.push(response.data[i])
                    }
                },(error)=>{
                    console.log(error)
                })
                this.tagTitle=""
            },
            deleteTag: function(id){
                axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
                axios.defaults.headers['content-type'] = 'application/json';
                
                axios.post(`/tags/${id}`, {_method: 'delete'}).then((response)=>{
                    this.tags=response.data;
                },(error)=>{
                    console.log(error)
                })
            },
            
        }

        
    }
    
    
</script>