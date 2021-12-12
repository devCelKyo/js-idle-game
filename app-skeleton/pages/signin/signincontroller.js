app.controller('SigninController', ["$scope", "$state","sampleFactory", "$http",

	function($scope, $state, sampleFactory, $http) {

		console.log('this is the signincontroller, hi!');

		sampleFactory.sampleFunction();

		$scope.gotohome = function() {
			$state.go("home");
		};

		$scope.username = "";
		$scope.password = "";

		$scope.register = function() {
		var donnee = {
			username : $scope.username,
			password : $scope.password
		};

		donnee = JSON.stringify(donnee);
		console.log(donnee);
		
		$http.post('http://localhost:8000/register', donnee)
		.then(function(response) {
			let data = response.data;
			let error = data.error;
			let icon = '';

			if (!error) {
				icon = 'success';
			}
			else {
				icon = 'error';
			}

			Swal.fire({icon: icon, title: data.message})
				.then(function() {
					if (!error) {
						$state.go("home");
					}
				});
		});
		};

  }
]);
