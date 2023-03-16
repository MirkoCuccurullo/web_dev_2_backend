<?php

namespace Models;

class Appointment
{
public int $id;
public string $client_name;
public int $lawyer_id;
public string $date;
public string $time_from;
public string $time_to;
public string $created;
public string $google_calendar_event_id;
public Lawyer $lawyer;

public string $lawyer_name;

}
