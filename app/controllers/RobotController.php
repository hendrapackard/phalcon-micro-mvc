<?php

use Phalcon\Http\Request;

class RobotController extends ControllerBase
{

    public function indexAction()
    {
        $projects = Robots::find();

        $data = [];

        foreach ($projects as $project) {
            $data[] = [
                'id'   => $project->id,
                'name' => $project->name,
                'type' => $project->type,
                'year' => $project->year,
            ];
        }

        return $this->sendResponse($data,200,'success');
    }

    public function showAction($id)
    {
        $project = Robots::findFirst("id = $id");

        if ($project === false) {

            $response = $this->sendResponse('',404,'data not found');

        } else {

            $data = [
                'id'   => $project->id,
                'name' => $project->name,
                'type' => $project->type,
                'year' => $project->year,
            ];

            $response = $this->sendResponse($data, 200,'success');

        }

        return $response;
    }

    public function saveAction()
    {
        $data = new Request();

        $request = $data->getJsonRawBody();

        $new_project = new Robots();

        $new_project->name = $request->name;
        $new_project->type = $request->type;
        $new_project->year = $request->year;


        // Check if the insertion was successful
        if ($new_project->save() === true) {

            $data =  [
                'id'   => $new_project->id,
                'name' => $new_project->name,
                'type' => $new_project->type,
                'year' => $new_project->year,
            ];

            $response = $this->sendResponse($data, 200,'success');

        } else {

            // Send errors to the client
            $response = $this->sendError($new_project);

        }

        return $response;
    }

    public function editAction($id)
    {
        $data = new Request();

        $request = $data->getJsonRawBody();

        $project = Robots::findFirst("id = $id");

        if ($project === false) {

            $response = $this->sendResponse('',404,'data not found');

        } else {

            $project->name = $request->name;
            $project->type = $request->type;
            $project->year = $request->year;

            // Check if the insertion was successful
            if ($project->save() === true) {

                $data =  [
                    'id'   => $project->id,
                    'name' => $project->name,
                    'type' => $project->type,
                    'year' => $project->year,
                ];

                $response = $this->sendResponse($data, 200,'success');

            } else {

                // Send errors to the client
                $response = $this->sendError($project);

            }
        }

        return $response;
    }

}

