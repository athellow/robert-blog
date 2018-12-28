<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadNewFolderRequest;
use App\Services\UploadsManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadController extends AdminController
{
    protected $manager;

    public function __construct(UploadsManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $folder = $request->get('folder');
        $data = $this->manager->folderInfo($folder);

        return view('admin.upload.index', $data);
    }

    public function createFolder(UploadNewFolderRequest $request)
    {
        $new_folder = $request->get('new_folder');
        $folder = $request->get('folder') . '/' . $new_folder;

        $result = $this->manager->createDirectory($folder);

        if ($result === true) {
            return redirect()->back()->with('success', '目录「' . $new_folder . '」创建成功.');
        }

        $error = $result ?: "创建目录出错.";
        return redirect()->back()->withErrors([$error]);
    }

    public function deleteFile(Request $request)
    {
        $del_file = $request->get('del_file');
        $path = $request->get('folder') . '/' . $del_file;

        $result = $this->manager->deleteFile($path);

        if ($result === true) {
            return redirect()->back()->with('success', '文件「' . $del_file . '」已删除.');
        }

        $error = $result ?: "文件删除出错.";
        return redirect()->back()->withErrors([$error]);
    }

    public function deleteFolder(Request $request)
    {
        $del_folder = $request->get('del_folder');
        $folder = $request->get('folder') . '/' . $del_folder;

        $result = $this->manager->deleteDirectory($folder);

        if ($result === true) {
            return redirect()->back()->with('success', '目录「' . $del_folder . '」已删除');
        }

        $error = $result ?: "An error occurred deleting directory.";
        return redirect()->back()->withErrors([$error]);
    }

    public function uploadFile(UploadFileRequest $request)
    {
        $file = $_FILES['file'];
        $fileName = $request->get('file_name')?: $file['name'];
        $path = str_finish($request->get('folder'), '/') . $fileName;
        $content = File::get($file['tmp_name']);

        $result = $this->manager->saveFile($path, $content);

        if ($result === true) {
            return redirect()->back()->with('success', '文件「' . $fileName . '」上传成功.');
        }

        $error = $result ?: "文件上传出错.";
        return redirect()->back()->withErrors([$error]);
    }
}
