<?php

namespace App\Console\Commands;

use App\Http\Requests\Schedule\DownloadScheduleRequest;
use App\Repositories\ScheduleRepository;
use App\Repositories\ScheduleVersionRepository;
use Illuminate\Console\Command;
use Jenssegers\Date\Date;

class CreateScheduleSnapshot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:snapshot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создает слепок расписания на момент ввода команды, сохраняет его в папку и фиксирует это в таблице schedule_versions';

    private $scheduleRepository;
    private $scheduleVersionRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        ScheduleRepository $scheduleRepository,
        ScheduleVersionRepository $scheduleVersionRepository
    )
    {
        parent::__construct();
        $this->scheduleRepository = $scheduleRepository;
        $this->scheduleVersionRepository = $scheduleVersionRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $downloadScheduleRequest = new DownloadScheduleRequest;
        \Jenssegers\Date\Date::setLocale('ru');
        $currentTime = Date::now()->format('d-M-Y H-i');
        $fileName = "Расписание_$currentTime";
        // Сохраняем расписание в папку, для маркировки указываем в имени файла текущую дату
        $downloadScheduleRequest->merge(['file_name' => $fileName]);
        $savedSchedulePath = $this->scheduleRepository->saveSchedule($downloadScheduleRequest);

        // В отдельную таблицу заносим запись, содержащую путь к сохраненному расписанию
        $this->scheduleVersionRepository->create([
            'schedule_path' => asset($savedSchedulePath),
            'name' => $fileName
        ]);
    }
}
