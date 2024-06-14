<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Contact;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        // Número de elementos por página
        $perPage = $request->input('perPage', 10); 

        // Término de búsqueda
        $search = $request->get('search', '');

        // Consulta base para obtener contactos
        $query = Contact::query();

         // Si hay un término de búsqueda, filtrar por nombre, teléfono, email o dirección
        if ($search) {
            $query->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhereHas('phones', function ($q) use ($search) {
                    $q->where('phone', 'like', '%' . $search . '%');
                })
                ->orWhereHas('emails', function ($q) use ($search) {
                    $q->where('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('addresses', function ($q) use ($search) {
                    $q->where('address', 'like', '%' . $search . '%');
                });
        }
         // Obtener los contactos con paginación, incluyendo relaciones
        $contacts = $query->with(['phones', 'emails', 'addresses'])->paginate($perPage);

        // Devolver la respuesta en formato JSON
        return response()->json($contacts, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();

        // Crear un nuevo contacto con los datos validados
        $contact = Contact::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name']
        ]);

        //Válida que la petición tenga teléfonos para registrarlos
        if ($request->has('phones')) {
            foreach ($request->input('phones') as $phone) {
                $contact->phones()->create(['phone' => $phone]);
            }
        }

        //Válida que la petición tenga correos para registrarlos
        if ($request->has('emails')) {
            foreach ($request->input('emails') as $email) {
                $contact->emails()->create(['email' => $email]);
            }
        }

        //Válida que la petición tenga direcciones para registrarlas
        if ($request->has('addresses')) {
            foreach ($request->input('addresses') as $address) {
                $contact->addresses()->create(['address' => $address]);
            }
        }
        // Devolver la respuesta en formato JSON con código 201 (creado)
        return response()->json($contact->load(['phones', 'emails', 'addresses']), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        // Buscar el contacto por ID, incluyendo relaciones
        $contact = Contact::with(['phones', 'emails', 'addresses'])->findOrFail($id);

        // Devolver la respuesta en formato JSON
        return response()->json($contact, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        
        //Buscar el contacto por ID
        $contact = Contact::findOrFail($id);

        // Actualizar el contacto con los datos validados
        $contact->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name']
        ]);

        $contact->phones()->delete();
        $contact->emails()->delete();
        $contact->addresses()->delete();

         //Válida que la petición tenga teléfonos para registrarlos
        if ($request->has('phones')) {
            foreach ($request->input('phones') as $phone) {
                $contact->phones()->create(['phone' => $phone]);
            }
        }

        //Válida que la petición tenga correos para registrarlos
        if ($request->has('emails')) {
            foreach ($request->input('emails') as $email) {
                $contact->emails()->create(['email' => $email]);
            }
        }

        //Válida que la petición tenga direcciones para registrarlas
        if ($request->has('addresses')) {
            foreach ($request->input('addresses') as $address) {
                $contact->addresses()->create(['address' => $address]);
            }
        }

        return response()->json($contact->load(['phones', 'emails', 'addresses']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Buscar el registro por ID para elimiar
        $contact = Contact::findOrFail($id);
        $contact->delete();
        
        // Devolver una respuesta vacía con código 204 (sin contenido)
        return response()->json(null, 204);
    }
}
