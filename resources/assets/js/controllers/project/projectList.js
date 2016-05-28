angular.module( 'app.controllers' )
    .controller( 'ProjectListController', [ '$scope', 'Project', function ( $scope, Project ) {

        $scope.projects        = [];
        $scope.totalProjects   = 0;
        $scope.projectsPerPage = 10;

        $scope.pagination = {
            current: 1
        };

        //Quando usuario clicar em uma páginação
        $scope.pageChanged = function ( newPage ) {
            getResultsPage( newPage );
        };

        function getResultsPage( pageNumber ) {

            Project.getProject( {
                page: pageNumber,
                limit: $scope.projectsPerPage
            }, function ( data ) {
                console.info( 'Obj: ', data );
                $scope.projects      = data.data;
                $scope.totalProjects = data.meta.pagination.total;
            } );
        }

        //Chama a função na primeira página
        getResultsPage( 1 );

    } ] );