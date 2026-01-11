
<?php
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
return function ($app) {
		
	// Add routes
	$app->get('/', function (Request $request, Response $response) {

		$logger = $this->get(LoggerInterface::class);
        $logger->info("/ Home route accessed");

		$response->getBody()->write('<a href="/hello/world">Try /hello/world</a>');
		return $response;
	});

	$app->get('/hello/{name}', function (Request $request, Response $response, $args) {
		$name = $args['name'];
		$response->getBody()->write("Hello, $name");
		return $response;
	});

	// API group
	$app->group('/api', function (RouteCollectorProxy $group) {
		
		// v1 group - Note: using $group instead of $app
		$group->group('/v1', function (RouteCollectorProxy $groupV1) {
			
			$groupV1->get('/tt/{id}', function (Request $request, Response $response, array $args) {
				//var_dump($_SERVER['REQUEST_URI']);
				
			   $id = $args['id'];
				
				$dateUtc = new \DateTime('now', new \DateTimeZone('UTC'));
				$utcFormatted = $dateUtc->format(\DateTime::ATOM);
				
				$data = [
					"version" => "v1",
					"id" => $id,
					"time" => $utcFormatted
				];

				$response->getBody()->write(json_encode($data));
				return $response->withHeader('Content-Type', 'application/json');
			});
		});

		// v2 group
		$group->group('/v2', function (RouteCollectorProxy $groupV2) {
			
			$groupV2->get('/tt/{id}', function (Request $request, Response $response, array $args) {
				
				
			   $id = $args['id'];
				
				$dateUtc = new \DateTime('now', new \DateTimeZone('UTC'));
				$utcFormatted = $dateUtc->format(\DateTime::ATOM);
				
				$data = [
					"version" => "v2",
					"id" => $id,
					"time" => $utcFormatted
				];

				$response->getBody()->write(json_encode($data));
				return $response->withHeader('Content-Type', 'application/json');
				
			});
		});
	});





	// Temporary Route Debugger
	$app->get('/debug-routes', function ($request, $response) use ($app) {
		$routes = $app->getRouteCollector()->getRoutes();
		$html = "<h1>Registered Routes</h1><table border='1' cellpadding='5'>";
		$html .= "<tr><th>Methods</th><th>Pattern (URL)</th></tr>";
		
		foreach ($routes as $route) {
			$methods = implode(', ', $route->getMethods());
			$pattern = $route->getPattern();
			$html .= "<tr><td><b>$methods</b></td><td><code>$pattern</code></td></tr>";
		}
		
		$html .= "</table>";
		$response->getBody()->write($html);
		return $response;
	});



	// Place this at the bottom, just before $app->run();
	$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
		$payload = json_encode([
			"error" => "Route not found",
			"requested_path" => $request->getUri()->getPath()
		]);
		
		$response->getBody()->write($payload);
		return $response
			->withHeader('Content-Type', 'application/json')
			->withStatus(404);
	});
};
