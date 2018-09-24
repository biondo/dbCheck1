<?php

namespace DoubleCheck\Http\Middleware;

use Closure;
use DoubleCheck\Repositories\ProjectRepository;

class CheckProjectOwner
{
    /**
     * @var ProjectRepository
     */
    private $repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = auth()->user()->getAuthIdentifier();
        $projectId = $request->project;

        if($this->repository->isOwner($projectId, $userId) == false){
            return ['error' => 'Access denied!'];
        }

        return $next($request);
    }
}
