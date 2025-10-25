<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Website\Gallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GalleryController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $galleryData = Gallery::with('images')->orderBy('id', 'desc');
            return DataTables::of($galleryData)
                ->addIndexColumn()
                ->addColumn('images', function ($row) {
                    return '<span class="badge bg-primary">' . $row->images->count() . ' Images</span>';
                })

                ->addColumn('actions', function ($row) {
                    return '<button id="viewGalleryBtn" class="btn-sm btn-success viewGalleryBtn"  data-bs-toggle="modal" data-bs-target="#viewGalleryModal" data-id="' . $row->id . '"><i class="fa fa-eye"></i></button>
                <button class="btn-sm btn-warning editGalleryBtn" data-id="' . $row->id . '"><i class="fa fa-pencil"></i></button>
                        <button class="btn-sm btn-danger deleteGalleryBtn" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['images', 'actions'])
                ->make(true);
        }
        $galleryData = Gallery::all();
        return view('web_pages/gallery/img_upload', compact('galleryData'));
    }

   public function show($id)
{
    $gallery = Gallery::with('images')->find($id);

    if (!$gallery) {
        return response()->json(['error' => 'Gallery not found'], 404);
    }

    $html = '
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 180px;">Gallery Title</th>
                        <td>' . e($gallery->title) . '</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>' . ($gallery->description ? e($gallery->description) : '<em class="text-muted">No description available</em>') . '</td>
                    </tr>
                </table>

                <h6 class="fw-bold text-secondary mt-4 mb-3">Gallery Images:</h6>
                <div class="row g-3">';

    foreach ($gallery->images as $img) {
        $html .= '
            <div class="col-md-4 col-sm-6">
                <div class="border rounded shadow-sm overflow-hidden">
                    <img src="' . asset('storage/' . $img->image_path) . '" class="img-fluid" style="height:150px; object-fit:cover;">
                </div>
            </div>';
    }

    $html .= '</div></div></div>';

    return response()->json(['html' => $html]);
}


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $gallery = Gallery::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('gallery', $filename, 'public'); // Custom filename
                $gallery->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return response()->json([
            'status' => 'Gallery Created Successfully',
            'gallery' => $gallery
        ]);
    }

    public function edit($id)
    {
        $galleries = Gallery::with('images')->findOrFail($id);
        return response()->json($galleries);
    }


   public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $gallery = Gallery::findOrFail($id);

    // 🔹 Step 1: Update text fields
    $gallery->update([
        'title' => $request->title,
        'description' => $request->description
    ]);

    // 🔹 Step 2: Delete only those images jinko frontend se remove kiya gaya ho
    if ($request->has('removed_images')) {
        $removedImages = json_decode($request->removed_images, true);

        if (!empty($removedImages)) {
            foreach ($removedImages as $imgId) {
                $img = $gallery->images()->where('id', $imgId)->first();

                if ($img) {
                    // Delete image file from storage
                    if (Storage::disk('public')->exists($img->image_path)) {
                        Storage::disk('public')->delete($img->image_path);
                    }
                    // Delete record from DB
                    $img->delete();
                }
            }
        }
    }

    // 🔹 Step 3: Save new uploaded images (without deleting old ones)
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('gallery', $filename, 'public');

            $gallery->images()->create([
                'image_path' => $path
            ]);
        }
    }

    // 🔹 Step 4: Return response with updated data
    return response()->json([
        'status' => 'Gallery Updated Successfully',
        'gallery' => $gallery->load('images')
    ]);
}


    // image update krne pr purani del nhi hogi new add ho jayegi 
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //         'remove_image_ids' => 'nullable|array' // agar user purani image remove karna chahe
    //     ]);

    //     $gallery = Gallery::findOrFail($id);

    //     // Update title & description
    //     $gallery->update([
    //         'title' => $request->title,
    //         'description' => $request->description
    //     ]);

    //     // ✅ Remove specific images if requested
    //     if ($request->filled('remove_image_ids')) {
    //         $imagesToRemove = $gallery->images()->whereIn('id', $request->remove_image_ids)->get();
    //         foreach ($imagesToRemove as $img) {
    //             if (Storage::disk('public')->exists($img->image_path)) {
    //                 Storage::disk('public')->delete($img->image_path);
    //             }
    //             $img->delete();
    //         }
    //     }

    //     // ✅ Add new uploaded images
    //     if ($request->hasFile('images')) {
    //         foreach ($request->file('images') as $image) {
    //             $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    //             $path = $image->storeAs('gallery', $filename, 'public');
    //             $gallery->images()->create([
    //                 'image_path' => $path
    //             ]);
    //         }
    //     }

    //     return response()->json([
    //         'status' => 'Gallery Updated Successfully'
    //     ]);
    // }


    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        // Delete all associated images
        foreach ($gallery->images as $img) {
            if (Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
            $img->delete();
        }

        // Delete gallery record
        $gallery->delete();

        return response()->json(['status' => 'Gallery Deleted Successfully']);
    }
}
