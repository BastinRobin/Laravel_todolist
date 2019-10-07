@extends('base')

@section('content')
<div class="row" style="margin-top:100px;">
	<div class="col-6 offset-3">
		<h3>My Todo List</h3>
		<ul class="list-group">
	
		  <li class="list-group-item list-group-item" v-for="(task, index) in tasks">
		  	
		  	<span v-if="!task.is_completed">@{{ task.body }}</span>
		  	<span v-if="task.is_completed"><strike>@{{ task.body }}</strike></span>
		
			<div class="pull-right">
				<button class="btn btn-xs btn-success" @click="mark_complete(task)"><span class="fa fa-check"></span></button>
				<button class="btn btn-xs btn-danger" @click="delete_task(task.id, index)"><span class="fa fa-trash"></span></button>
			</div>
		  </li>
		  <li class="list-group-item list-group-item">
		  	<div class="input-group mb-3">
		  	  <input type="text" class="form-control" v-model="form.body">
		  	  <div class="input-group-append">
		  	    <button class="btn btn-outline-secondary" type="button" @click="create_task">Add Task</button>
		  	  </div>
		  	</div>
		  </li>
		</ul>
	</div>
</div>
@endsection


@section('script')
<script type="text/javascript">

 	var app = new Vue({
 		el: '#app',
 		data: {
 			tasks: {!! $tasks->toJson() !!},
 			form:{}
 		},
 		methods: {

 			create_task: function() {

 				var vm = this;

 				axios.post('/tasks', this.form)
 					.then(function(response) {
 						vm.tasks.push(response.data);
 						vm.form = {};

 					}).catch(function(error) {
 						console.log(error);
 					});


 			},

 			update_task: function(id) {

 			},

 			mark_complete: function(task) {

 				task.is_completed = true;
 				

 				axios.put('/tasks/' + task.id, task)
 					.then(function(response) {
 						console.log(response);
 					}).catch(function(error) {
 						console.log(error);
 					})

 			},

 			delete_task: function(id, index) {
 				var vm = this;
 				axios.delete('/tasks/' + id)
 					.then(function(response) {
 						console.log(response);
 						vm.$delete(vm.tasks, index);


 					}).catch(function(error) {
 						console.log(error);
 					});
 			}


 		}
 	});

</script>
@endsection