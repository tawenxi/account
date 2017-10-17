<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatCreateRequest;
use App\Http\Requests\CatUpdateRequest;
use App\Repositories\CatRepository;
use App\Validators\CatValidator;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class CatsController extends Controller
{
    /**
     * @var CatRepository
     */
    protected $repository;

    /**
     * @var CatValidator
     */
    protected $validator;

    public function __construct(CatRepository $repository, CatValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $cats = $this->repository->pushCriteria(\App\Criteria\MyCriteria::class)->all();

        //$cats = $this->repository->getByCriteria(new \App\Criteria\MyCriteria());

        dd($cats);

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $cats,
            ]);
        }

        return view('cats.index', compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CatCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CatCreateRequest $request)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $cat = $this->repository->create($request->all());

            $response = [
                'message' => 'Cat created.',
                'data'    => $cat->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag(),
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cat = $this->repository->find($id);

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $cat,
            ]);
        }

        return view('cats.show', compact('cat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat = $this->repository->find($id);

        return view('cats.edit', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CatUpdateRequest $request
     * @param string           $id
     *
     * @return Response
     */
    public function update(CatUpdateRequest $request, $id)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $cat = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Cat updated.',
                'data'    => $cat->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag(),
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Cat deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Cat deleted.');
    }
}
