<?php

/**
 * File: ProjectTaskController.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 27/02/16
 * Time: 15:33
 * Project: lacc_project
 * Copyright: 2016
 */

namespace LACC\Http\Controllers;

use Illuminate\Http\Request;
use LACC\Http\Requests;
use LACC\Repositories\ProjectTaskRepository;
use LACC\Services\ProjectService;
use LACC\Services\ProjectTaskService;

class ProjectTaskController extends Controller
{
		/**
		 * @var ProjectTaskRepository
		 */
		protected $repository;
		/**
		 * @var ProjectTaskService
		 */
		protected $service;
		/**
		 * @var ProjectService
		 */
		protected $projectService;

		public function __construct( ProjectTaskRepository $taskRepository,
		                             ProjectTaskService $service,
		                             ProjectService $projectService )
		{
				$this->repository     = $taskRepository;
				$this->service        = $service;
				$this->projectService = $projectService;
		}

		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index( $id )
		{
//				return $this->service->all();
				if ( !$this->projectService->checkProjectPermissions( $id ) ):
						return [ 'error' => 'Access Forbidden' ];
				endif;

				return $this->repository->findWhere( [ 'project_id' => $id ] );
		}

		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function store( Request $request )
		{
				$projectId = $request->projectId;

				if ( !$this->projectService->checkProjectPermissions( $projectId ) ):
						return [ 'error' => 'Access Forbidden' ];
				endif;

				return $this->service->create( $request->all() );
		}

		/**
		 * Display the specified resource.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function show( $id, Request $request )
		{
				$projectId = $request->projectId;

				if ( !$this->projectService->checkProjectPermissions( $projectId ) ):
						return [ 'error' => 'Access Forbidden' ];
				endif;

				return $this->service->searchById( $id );
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function update( Request $request, $taskId )
		{
				$projectId = $request->projectId;

				if ( !$this->projectService->checkProjectPermissions( $projectId ) ):
						return [ 'error' => 'Access Forbidden' ];
				endif;

				return $this->service->update( $request->all(), $taskId );
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function destroy( $id, Request $request )
		{
				$projectId = $request->projectId;

				if ( !$this->projectService->checkProjectPermissions( $projectId ) ):
						return [ 'error' => 'Access Forbidden' ];
				endif;

				try {
						$dataTask = $this->service->searchById( $id );

						if ( $dataTask ) {
								$this->repository->delete( $id );
								return response()->json( [
										'message' => 'Tarefa deletada com sucesso!',
								] );

						}
				} catch ( \Exception $e ) {
						return response()->json( [
								'message' => $e->getMessage(),
						] );
				}
		}
}
