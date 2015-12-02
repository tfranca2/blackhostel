select * from quarto q left join reserva r on r.id_quarto = q.id_quarto
where r.situacao = 3 or r.id_reserva is null;