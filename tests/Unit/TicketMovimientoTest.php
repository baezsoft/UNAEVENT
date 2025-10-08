<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Movimiento;
use App\Models\Acreditado;
use App\Models\Actividad;
use App\Models\Participante;
use App\Models\Evento;
use App\Support\TicketMovimiento;
use Illuminate\Support\Facades\Schema;

class TicketMovimientoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function genera_ticket_para_movimiento_sin_acreditado()
    {
        // Crear evento mínimo si la migración existe
        if (Schema::hasTable('eventos')) {
            $eventoId = \DB::table('eventos')->insertGetId([
                'nombre' => 'Evento X',
                'descripcion' => 'Desc',
                'fecha' => now()->toDateString(),
                'lugar' => 'Lugar X',
                'tarifa' => 0,
                'inhabilitado' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $eventoId = null;
        }

        $mov = Movimiento::create([
            'id_evento' => $eventoId,
            'id_acreditado' => null,
            'tipo' => 'entrada',
            'monto' => 150.50,
            'descripcion' => 'Inscripción',
            'fecha' => now(),
            'inhabilitado' => false,
        ]);

        $ticket = TicketMovimiento::generar($mov->id);

        $this->assertNotNull($ticket['movimiento']);
        $this->assertNull($ticket['acreditado']);
        $this->assertIsArray($ticket['actividades']);
        $this->assertEquals('entrada', $ticket['movimiento']['tipo']);
    }

    /** @test */
    public function genera_ticket_para_movimiento_con_acreditado_y_actividades()
    {
        if (!Schema::hasTable('eventos')) {
            $this->markTestSkipped('Tabla eventos no disponible en migraciones.');
        }

        $eventoId = \DB::table('eventos')->insertGetId([
            'nombre' => 'Evento Y',
            'descripcion' => 'Desc Y',
            'fecha' => now()->toDateString(),
            'lugar' => 'Lugar Y',
            'tarifa' => 0,
            'inhabilitado' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $acreditado = Acreditado::create([
            'id_evento' => $eventoId,
            'fecha_acreditacion' => now(),
            'estado' => 'activo',
            'dni' => '12345678',
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'fecha_nacimiento' => now()->subYears(30),
            'genero' => true,
            'nacionalidad' => 'AR',
            'telefono' => '1111',
            'correo' => 'juan@example.com',
            'inhabilitado' => false,
        ]);

        $actividadId = \DB::table('actividades')->insertGetId([
            'nombre' => 'Charla 1',
            // Crear usuario mínimo
            'id_usuario' => \DB::table('usuarios')->insertGetId([
                'nombre' => 'User',
                'apellido' => 'Test',
                'direccion' => null,
                'password' => bcrypt('secret'),
                'correo' => 'user@test.com',
                'tel' => null,
                'estado' => 'activo',
                'ci' => 'CI123',
                'cargo' => 'Admin',
                'inhabilitado' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]),
            'id_disertante' => null,
            'id_sala' => null,
            'id_disciplina' => null,
            'id_evento' => $eventoId,
            'fecha' => now()->toDateString(),
            'hora_inicio' => '09:00:00',
            'hora_fin' => '10:00:00',
            'inhabilitado' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Participante::create([
            'id_acreditado' => $acreditado->id,
            'id_actividad' => $actividadId,
            'asistencia' => false,
        ]);

        $mov = Movimiento::create([
            'id_evento' => $eventoId,
            'id_acreditado' => $acreditado->id,
            'tipo' => 'entrada',
            'monto' => 500,
            'descripcion' => 'Pago Total',
            'fecha' => now(),
            'inhabilitado' => false,
        ]);

        $ticket = TicketMovimiento::generar($mov->id);

        $this->assertEquals($acreditado->dni, $ticket['acreditado']['dni']);
        $this->assertCount(1, $ticket['actividades']);
        $this->assertEquals('Charla 1', $ticket['actividades'][0]['nombre']);
    }
}
