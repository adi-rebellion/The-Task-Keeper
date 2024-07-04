<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;

use App\Repositories\TaskRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**

 * @OA\Schema(
 *     schema="Task",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the task"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Status of the task"
 *     ),
 *     @OA\Property(
 *         property="start_date",
 *         type="string",
 *         format="date",
 *         description="Start date of the task"
 *     ),
 *     @OA\Property(
 *         property="due_date",
 *         type="string",
 *         format="date",
 *         description="Due date of the task"
 *     ),
 *     @OA\Property(
 *         property="priority",
 *         type="string",
 *         description="Priority of the task"
 *     ),
 *     @OA\Property(
 *         property="notes",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(
 *                 property="id",
 *                 type="integer",
 *                 description="ID of the note"
 *             ),
 *             @OA\Property(
 *                 property="note",
 *                 type="string",
 *                 description="Content of the note"
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="string",
 *                 format="date-time",
 *                 description="Creation date of the note"
 *             ),
 *             @OA\Property(
 *                 property="attachments",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="id",
 *                         type="integer",
 *                         description="ID of the attachment"
 *                     ),
 *                     @OA\Property(
 *                         property="file_path",
 *                         type="string",
 *                         description="Path of the attachment file"
 *                     )
 *                 )
 *             )
 *         )
 *     )
 * )
 */

/**

 * @OA\Schema(
 *     schema="Note",
 *     @OA\Property(
 *         property="subject",
 *         type="string",
 *         description="Subject of the note"
 *     ),
 *     @OA\Property(
 *         property="note",
 *         type="string",
 *         description="Content of the note"
 *     ),
 *     @OA\Property(
 *         property="attachments",
 *         type="array",
 *         @OA\Items(
 *             type="string",
 *             format="binary",
 *             description="Attachment file"
 *         )
 *     )
 * )
 */

 class TaskController extends Controller
{
    use ResponseTrait;
    public $taskAccess;



    public function __construct(TaskRepository $taskAccess)
    {
        $this->taskAccess = $taskAccess;

    }

     /**
     * @OA\Get(
     *     path="/api/tasks",
     *     operationId="getTasks",
     *     security={{"bearer":{}}},
     *     tags={"Tasks"},
     *     summary="Get list of tasks",
     *     description="Returns list of tasks with filters applied",
 *     @OA\Parameter(
 *         name="status",
 *         in="query",
 *         description="Filter by status",
 *         required=false,
 *         @OA\Schema(
 *             type="string",
 *             enum={"New", "Incomplete", "Complete"}
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="start_date",
 *         in="query",
 *         description="Filter by start date",
 *         required=false,
 *         @OA\Schema(
 *             type="string",
 *             format="date"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="due_date",
 *         in="query",
 *         description="Filter by due date",
 *         required=false,
 *         @OA\Schema(
 *             type="string",
 *             format="date"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="priority",
 *         in="query",
 *         description="Filter by priority",
 *         required=false,
 *         @OA\Schema(
 *             type="string",
 *             enum={"High", "Low", "Medium"}
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="note_content",
 *         in="query",
 *         description="Filter by note content",
 *         required=false,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="note_created_at",
 *         in="query",
 *         description="Filter by note creation date",
 *         required=false,
 *         @OA\Schema(
 *             type="string",
 *             format="date"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="perPage",
 *         in="query",
 *         description="Number of tasks per page",
 *         required=false,
 *         @OA\Schema(
 *             type="integer",
 *             default=10
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="order",
 *         in="query",
 *         description="Order of the results",
 *         required=false,
 *         @OA\Schema(
 *             type="string",
 *             default="desc"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="orderBy",
 *         in="query",
 *         description="Order by field",
 *         required=false,
 *         @OA\Schema(
 *             type="string",
 *             default="id"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",

 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
    public function index(Request $request)
    {


       try{
            $requestedTaskData = $this->taskAccess->getAll($request->all());
            return $this->responseSuccess($requestedTaskData,'Tasks fetched successfully.');
         }catch(Exception $e){
         return $this->responseError([],$e->getMessage());
     }

    }



 /**
 * @OA\Post(
 *     path="/api/tasks",
 *     operationId="createTaskWithNotesAndAttachments",
  *     security={{"bearer":{}}},
 *     tags={"Tasks"},
 *     summary="Create a task with multiple notes and attachments",
 *     description="Creates a task with multiple notes, each having multiple attachments.",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Task data with notes and attachments",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="subject",
 *                     type="string",
 *                     description="Subject of the task"
 *                 ),
 *                 @OA\Property(
 *                     property="start_date",
 *                     type="string",
 *                     format="date",
 *                     description="Start date of the task (YYYY-MM-DD)"
 *                 ),
 *                 @OA\Property(
 *                     property="due_date",
 *                     type="string",
 *                     format="date",
 *                     description="Due date of the task (YYYY-MM-DD)"
 *                 ),
 *                 @OA\Property(
 *                     property="status",
 *                     type="string",
 *                     description="Status of the task"
 *                 ),
 *                 @OA\Property(
 *                     property="priority",
 *                     type="string",
 *                     description="Priority of the task"
 *                 ),
 *                 @OA\Property(
 *                     property="notes",
 *                     type="array",
 *                     @OA\Items(
 *                         ref="#/components/schemas/Note"
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Task created successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
    public function store(TaskCreateRequest $request):JsonResponse
    {

        try{
                $requestedTaskData = $this->taskAccess->create($request->all());
                $noteAssoc = $this->taskAccess->assocNotes($request->notes,$requestedTaskData);
                return $this->responseSuccess($requestedTaskData,'Task created successfully.');
             }catch(Exception $e){
                 return $this->responseError([],$e->getMessage());
         }
    }



}
