<template>
    <!--Todoを入れていく大枠の箱を設定-->
    <div class="container-fruid" style="overflow-y: scroll;">
        
        <!--新しくTodoを設定するmodal画面（それぞれのGoalごと＜＝goalIdごと＞）-->
        <div class="modal fade" :id="'todoModal'+goalId" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Todo Content</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input v-model="content" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="addNewTodo">Add</button>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!--作ったTodoカードの表示設定-->
        <div v-for="(todo, key, index) in todos" :key=index>
            
            <!--終わってない場合＜done＞-->
            <div class="d-flex justify-content-center m-3">
                <div class="card" style="width: 18rem;" v-if="todo.done == 0">
                    <div class="card-body">
                        <h5 class="card-title">{{todo.content}}</h5>
                        <!--タグ挿入-->
                        <div class="mb-2">
                            Tag:<span v-for="(key,index) in todo.tags" :key="index"><small class="mr-1">{{todo.tags[index].title}}</small></span>
                        </div>
                        <!--タグ挿入終-->
                        <h6 class="card-subtitle mb-2 text-muted">{{todo.created_at}}</h6>
                    </div>
                    <div class="btn-group position-absolute dropdown" style="top:10px; right:4px;">
                        <i class="fa fa-ellipsis-v p-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="text-center text-success" v-on:click="doneTodoUpdate(todo)" v-if="todo.done == 0">Done</div>
                            <div class="text-center" v-on:click="doneTodoUpdate(todo)" v-if="todo.done == 1">Not Done</div>
                            <div class="text-center" data-toggle="modal" :data-target="'#todoModal'+goalId+todo.id" v-on:click="content = todo.content">Edit</div>
                            <div class="text-center" data-toggle="modal" :data-target="'#todoSortModal'+goalId+todo.id" v-on:click="content = todo.content">Sort</div>
                            <div class="text-center text-danger" v-on:click="deleteTodo(todo)">Delete</div>
                        </div>
                    </div>
                </div>
            
            
            
                <!--終わった場合＜done＞-->
                <div class="card" style="width: 18rem;" v-if="todo.done == 1">
                    <div class="card-body">
                        　<!--↓斜線を入れてくださいの設定-->
                           <h5 class="card-title"><s>{{todo.content}}</s></h5>
                           <!--タグ挿入-->
                           <div class="mb-2">
                               Tag:<span v-for="(key, index) in todo.tags" :key="index"><small class="mr-1">{{todo.tags[index].title}}</small></span>
                           </div>
                           <!--タグ挿入終-->
                        <h6 class="card-subtitle mb-2 text-muted">{{todo.created_at}}</h6>
                    </div>
                       <div class="btn-group position-absolute dropdown" style="top:10px; right:4px;">
                           <i class="fa fa-ellipsis-v p-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                           <div class="dropdown-menu dropdown-menu-right">
                               <div class="text-center text-success" v-on:click="doneTodoUpdate(todo)" v-if="todo.done == 0">Done</div>
                               <div class="text-center" v-on:click="doneTodoUpdate(todo)" v-if="todo.done == 1">Not Done</div>
                               <div class="text-center" data-toggle="modal" :data-target="'#todoModal'+goalId+todo.id" v-on:click="content = todo.content">Edit</div>
                               <div class="text-center" data-toggle="modal" :data-target="'#todoSortModal'+goalId+todo.id" v-on:click="content = todo.content">Sort</div>
                               <div class="text-center text-danger" v-on:click="deleteTodo(todo)">Delete</div>
                           </div>
                       </div>
                </div>
                
            </div>

        
        <!--Todoの編集画面を作成-->
        <div class="modal fade" :id="'todoModal'+goalId+todo.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Todo Content</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input v-model="content" class="form-control">
                        <!--タグ挿入-->
                        <div v-for="(key, index) in tags" :key="index">
                            <div class="form-check">
                                <span v-if="checkTag(todo.tags, tags[index].title)">
                                    <span>✔</span>
                                    <button class="btn btn-secondary m-1" v-on:click="removeTodoTag(todo.id, tags[index].id)">{{tags[index].title}}</button>
                                </span>
                                <span v-else>
                                    <span>▢</span>
                                    <button class="btn btn-secondary m-1" v-on:click="addTodoTag(todo.id, tags[index].id)">{{tags[index].title}}</button>
                                </span>
                            </div>
                        </div>
                        <!--タグ挿入終-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="editTodoContent(todo)">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!--Todoのソートする画面を作成-->
        <div class="modal fade" :id="'todoSortModal'+goalId+todo.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sort Todo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <select class="form-control" id="exampleFormControlSelect1" v-model="sort_id">
                            <option v-for="(todo, key, index) in todos" :key=index>
                                <!--keyはindexのため、0から数える。1から表示するようにするため、＋１-->
                                {{ key + 1 }}
                            </option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="sortTodo(todo)">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
    </div>
    
    
    
</template>
<script>
import axios from "axios"
import $ from "jquery"
export default {
    // Goal.vueからgoalId(=goal.id)のデータをもってきている
    props: ['goalId'],
    
    //データの設定
    data: function(){
        return {
            id:"",
            content:"",
            todos:[],
            tags:[],
            sort_id:""
        }
    },
    
    //　DOM生成直後に実行すること
    mounted: function(){
        this.getAllTodos();
        this.getAllTags();
    },
    methods:{
        // getリクエストの該当URL（/goals/${this.goalId}todos）の時は、コンソールに受け取ったデータとtodosの配列にデータを格納してください
        getAllTodos:function(){
            axios.get(`/goals/${this.goalId}/todos`).then((response)=>{
                console.log(response)
                for(let i = 0; i < response.data.length; i++){
                    this.todos.push(response.data[i])
                }
            },(error)=>{
                console.log(error)
            })
        },
        
        // tagの設定
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
        checkTag: function(tags, title){
            let result = tags.filter(function(item, index){
                if(item.title === title)
                return true;
            })
            
            console.log(result.length);
            if(result.length > 0){
                return result[0].title == title
            }
            return false;
        },
        addTodoTag: function(todoId, tagId){
            axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
            axios.defaults.headers['content-type'] = 'application/json';
            axios.post(`/goals/${this.goalId}/todos/${todoId}/tags/${tagId}`).then((response)=>{
                this.todos.length = 0;
                for(let i = 0; i < response.data.length; i++){
                    this.todos.push(response.data[i])
                }
            },(error)=>{
                console.log(error)
            })
            this.$forceUpdate();
        },
        removeTodoTag: function(todoId, tagId){
            axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
            axios.defaults.headers['content-type'] = 'application/json';
            axios.post(`/goals/${this.goalId}/todos/${todoId}/tags/${tagId}`, {_method: "delete"}).then((response)=>{
                this.todos = response.data;
            },(error)=>{
                console.log(error)
            })
            this.$forceUpdate();
        },
        
        // Todoを新しく設定した時のメソッド
        addNewTodo: function(){
            axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
            axios.defaults.headers['content-type'] = 'application/json';
            axios.post(`/goals/${this.goalId}/todos`, {content: this.content, position: this.todos.length}).then((response)=>{
                this.todos.length = 0;
                for(let i = 0; i < response.data.length; i++){
                    this.todos.push(response.data[i])
                }
            },(error)=>{
                console.log(error)
            })
            this.content=""
        },
        // 終わったTodoの処理をしたときのメソッド（done）
        doneTodoUpdate: function(todo){
            axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
            axios.defaults.headers['content-type'] = 'application/json';
            let done= todo.done == 0 ? true : false;
            axios.post(`/goals/${this.goalId}/todos/${todo.id}`, {content: todo.content, position: todo.position, done: done, _method:"patch"}).then((response)=>{
                this.todos.length=0;
                console.log(response)
                for(let i = 0; i<response.data.length; i++){
                    this.todos.push(response.data[i])
                }
            },(error)=>{
                console.log(error)
            })
            this.content=""
        },
        
        // Todoを編集した時のメソッド
        editTodoContent: function(todo){
            axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
            axios.defaults.headers['content-type'] = 'application/json';
            axios.post(`/goals/${todo.goal_id}/todos/${todo.id}`, {content: this.content, position: todo.position, done: todo.done, _method:"patch"}).then((response)=>{
                this.todos.length = 0;
                console.log(response)
                for(let i = 0; i< response.data.length; i++){
                    this.todos.push(response.data[i])
                }
            },(error)=>{
                console.log(error)
            })
            this.content=""
        },
        

        // Todoを削除した時のメソッド
        deleteTodo: function(todo){
            if(confirm("Delete?")){
                axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
                axios.defaults.headers['content-type'] = 'application/json';
                axios.post(`/goals/${this.goalId}/todos/${todo.id}`, {_method: "delete"}).then((response)=>{
                    this.todos = response.data;
                },(error)=>{
                    console.log(error)
                })
            }
        },
        
        // Todoにsortをかけた時のメソッド
        sortTodo: function(todo){
            axios.defaults.headers['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
            axios.defaults.headers['content-type'] = 'application/json';
            console.log(this.sort_id)
            
            // HTMLの設定で、Keyをindex上＋１にしたため、プログラム側で並び変えを行う際にindexの正しい数字に戻すためにsort_idに―1している
            axios.post(`/goals/${this.goalId}/todos/${todo.id}/sort`, {sortId: this.sort_id - 1}).then((response)=>{
                this.todos.length=0;
                console.log(response)
                for(let i = 0; i< response.data.length; i++){
                    this.todos.push(response.data[i])
                }
            },(error)=>{
                console.log(error)
            })
        },
        
    }
    
    
    
}
    
    
    
    
</script>