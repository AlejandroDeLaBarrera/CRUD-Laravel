<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Hobbie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller{
    //Para permitir acceso sólo a admin, proteger con middleware
    public function __construct() {
        $this->middleware('admin');  //se debe definir este middleware
    }

    public function index() {
        // $customers = Customer::with('hobbies')->get;
        // return view('customers.index', compact('customers'));
         // Obtener todos los customers con sus hobbies asociados
    $customers = Customer::where('user_id', auth()->id())
    ->with('hobbies') // Esto carga la relación de hobbies
    ->get();

        // Retornar la vista con los customers
    return view('customers.index', ['customers' => $customers]);
    }

    public function create(){
        $hobbies = Hobbie::all();  //para obtener todos los hobbies
        return view('customers.create', compact('hobbies'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'hobbies' => 'required|array',
            'hobbies.*' => 'exists:hobbies,id',
        ]);

        // Crear el nuevo customer y asociarlo con el usuario autenticado
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->surname = $request->input('surname');
        $customer->user_id = Auth::id(); // Asigna el ID del usuario autenticado al campo user_id
        $customer->save();

        // Asignar hobbies seleccionados
        $customer->hobbies()->sync($request->input('hobbies'));

        // Redirigir al listado de customers con mensaje de éxito
        return redirect()->route('customers.index')->with('success', 'Customer creado correctamente');
    }

    public function edit(Customer $customer){
        $hobbies = Hobbie::all();
        return view('customers.edit', compact('customer', 'hobbies'));
    }

    public function update(Request $request, Customer $customer){
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'hobbies' => 'array',
        ]);

        $customer->update($request->only(['name', 'surname']));
        $customer->hobbies()->sync($request->hobbies);

        return redirect()->route('customers.index');
    }

    public function destroy(Customer $customer){
        $customer->delete();
        return redirect()->route('customers.index');
    }
}
