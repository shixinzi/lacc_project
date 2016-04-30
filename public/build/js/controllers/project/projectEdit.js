angular.module( 'app.controllers' )
    .controller( 'ProjectNoteEditController',
    [ '$scope', '$location', '$routeParams', 'ProjectNote',
        function ( $scope, $location, $routeParams, ProjectNote ) {

            /**
             * :id do resource (service/projectNote.js)
             * $routeParams.id da rota (app.js)
             * @type {projectNote.get}
             */
            ProjectNote.get( { id: $routeParams.id, idNote: $routeParams.idNote }, function ( data ) {
                $scope.projectNote = data;
            } );

            $scope.save = function () {
                if ( $scope.form.$valid ) {

                    ProjectNote.update( { idNote: $scope.projectNote.id }, $scope.projectNote, function () {
                        swal( "Alterado!", "A nota foi alterada com sucesso!.", "success" );
                        $location.path( '/project/' + $scope.projectNote.project_id + '/notes' );
                    } );
                }
            };
        } ] );