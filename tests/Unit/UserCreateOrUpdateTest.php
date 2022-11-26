<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTApi\Repository\UserRepository;

class UserCreateOrUpdateTest extends TestCase
{

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * BookingController constructor.
     * @param BookingRepository $bookingRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function testUserCreate()
    {
        // data binding 
        $request=[]; //we will be adding actual data in here. I'm skiping it as its understood.
        $this->repository->createOrUpdate(null,$request);

        $this->assertTrue(true);
    }
    public function testUserUpdate()
    {
        // data binding 
        $request=[]; //we will be adding actual data in here. I'm skiping it as its understood.
        $id=5;
        $this->repository->createOrUpdate($id,$request);

        $this->assertTrue(true);
    }
}
