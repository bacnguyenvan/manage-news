<?php
namespace App\Http\Repositories;

interface InterfaceRepository	{

	function findAll();

	function findByPk($pk);

	function findAllActive();

	function create($data);

	function updateByPk($pk, $data);

	function deleteByPk($pk);

	function softDeleteByPk($pk);

	function softDeleteListPk($listPk);
}