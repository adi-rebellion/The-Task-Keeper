<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\Note;
use App\Models\Task;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;


class TaskRepository implements CrudInterface
{
    use ResponseTrait;

    public function getAll(array $filterData):Paginator
    {
        $filter =  $this->getFilterData($filterData);


        $query = Task::with('notes.attachments')->orderBy($filter['orderBy'], $filter['order']);


        if(!empty($filter['status'])){
            $query->where(function($query) use ($filter){
                $query->where('status',$filter['status']);
            });
        }
        if(!empty($filter['start_date'])){
            $query->where(function($query) use ($filter){
                $query->where('start_date',$filter['start_date']);
            });
        }

        if(!empty($filter['due_date'])){
            $query->where(function($query) use ($filter){
                $query->where('due_date',$filter['due_date']);
            });
        }

        if(!empty($filter['priority'])){
            $query->where(function($query) use ($filter){
                $query->where('priority',$filter['priority']);
            });
        }

        if (!empty($filter['notes'])) {
            $query->has ('notes');
        }

        if (!empty($filter['note_content'])) {
            $query->whereHas('notes', function ($query) use ($filter) {
                $query->where('note', 'like', '%' . $filter['note_content'] . '%');
            });
        }

        if (!empty($filter['note_created_at'])) {
            $query->whereHas('notes', function ($query) use ($filter) {
                $query->where('created_at', $filter['note_created_at']);
            });
        }


        return $query->paginate($filter['perPage']);
    }

    public function getFilterData(array $filterData)
    {
        $defaultFilter = [
            'perPage' => 10,
            'order' => 'desc',
            'orderBy' => 'id',
            'priority' => 'High',
            'note_content' => null,
            'note_created_at' => null,
            'start_date' => null,
            'due_date' => null,
            'status' => null
        ];

        return array_merge($defaultFilter,$filterData);
    }

    public function getById(int $id): ?Task
    {
        return Task::find($id);
    }

    public function create(array $inputData): ?Task
    {
        return Task::create($inputData);
    }

       /**
     * Associates notes with the given task.
     *
     * @param array $notesData
     * @param Task $taskData
     * @return void
     */

    public function assocNotes(array $notesData,Task $taskData)
    {

        foreach ($notesData as $note) {
            $noteAssoc = $taskData->notes()->create($note);
            if (isset($note['attachments'])) {
                    $this->assocAttachment($note['attachments'],$noteAssoc);
            }
        }
    }

       /**
     * Associates attachments with the given note.
     *
     * @param array $attachmentData
     * @param Note $taskData
     * @return void
     */

    public function assocAttachment(array $attachmentData,Note $taskData):void
    {
        foreach ($attachmentData as $file) {
            try{

                if ($file instanceof UploadedFile && $file->isFile()) {
                    $file_path = $this->uploadAttachment($file);
                } else {
                    $file_path = $file;
                }

                $taskData->attachments()->create(['file_path' => $file_path]);
            }catch(Exception $e){
                $this->responseError([],$e->getMessage());
            }

        }
    }

    public function uploadAttachment($file): string
    {
        try{
            $fileName = time(). '.'. $file->extension();
            $file->storePubliclyAs('public', $fileName);
            return $fileName;
        }catch(Exception $e){
            $this->responseError([],$e->getMessage());
        }
    }




}
