<?php
/**
 * API to add a new project
 */
$app->post('/api/projects/add/', function () use($app){
	
	$json = $app->request()->getBody();
	$project = json_decode($json);

	array_walk_recursive($project, function(&$value){
		$value = utf8_decode($value);
	});
	try{
		$projectDB = Model::factory('Projects')->create();
		$projectDB->title = $project->name;
		$projectDB->description = $project->description;
		$projectDB->startDate = $project->startDate;
		if($project->endDate){
			$projectDB->endDate = $project->endDate;
		}else{
			$projectDB->endDate = null;
		}
		$projectDB->status = "Started";
		$projectDB->url = $project->url;
		$projectDB->note = $project->note;
		$projectDB->clientId = $project->clientId;
		$projectDB->projectLeaderId = $project->projectLeader;
		$projectDB->save();
		if(isset($project->usersAssigned) && in_array($project->projectLeader, $project->usersAssigned)){
			foreach($project->usersAssigned as $user){
				$userAssigned = Model::factory('Assignments')->create();
				$userAssigned->userId = $user;
				$userAssigned->projectId = $projectDB->projectId;
				$userAssigned->rate = 55.00;
				$userAssigned->save();
			}
		}else if(isset($project->usersAssigned) && !in_array($project->projectLeader, $project->usersAssigned)){
			
			foreach($project->usersAssigned as $user){
				$userAssigned = Model::factory('Assignments')->create();
				$userAssigned->userId = $user;
				$userAssigned->projectId = $projectDB->projectId;
				$userAssigned->rate = 55.00;
				$userAssigned->save();
			}
			$userAssigned = Model::factory('Assignments')->create();
			$userAssigned->userId = $project->projectLeader;
			$userAssigned->projectId = $projectDB->projectId;
			$userAssigned->rate = 55.00;
			$userAssigned->save();
		}else{ 
			$userAssigned = Model::factory('Assignments')->create();
			$userAssigned->userId = $project->projectLeader;
			$userAssigned->projectId = $projectDB->projectId;
			$userAssigned->rate = 55.00;
			$userAssigned->save();
		}
		exit('{"success": "true"}');
	}catch(Exception $e){
		exit('{"error": "'.$e->getMessage().'"}');
	}

})->name("API_AddNewProject");