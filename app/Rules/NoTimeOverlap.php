<?php

    namespace App\Rules;

    use Illuminate\Contracts\Validation\Rule;
    use App\Models\Peminjaman;

    class NoTimeOverlap implements Rule
    {
        protected $ruangan_id;
        protected $tanggal_peminjaman;
        protected $waktu_selesai;

        public function __construct($ruangan_id, $tanggal_peminjaman, $waktu_selesai)
        {
            $this->ruangan_id = $ruangan_id;
            $this->tanggal_peminjaman = $tanggal_peminjaman;
            $this->waktu_selesai = $waktu_selesai;
        }

        public function passes($attribute, $value)
        {
            if (!$this->ruangan_id || !$this->tanggal_peminjaman || !$this->waktu_selesai) {
                return true;
            }

            $waktu_mulai_baru = $value;
            $waktu_selesai_baru = $this->waktu_selesai;

            $isOverlap = Peminjaman::where('ruangan_id', $this->ruangan_id)
                ->where('tanggal_peminjaman', $this->tanggal_peminjaman)
                ->where('status', 'not like', 'Ditolak%')
                ->where(function ($query) use ($waktu_mulai_baru, $waktu_selesai_baru) {
                    $query->where('waktu_mulai', '<', $waktu_selesai_baru)
                        ->where('waktu_selesai', '>', $waktu_mulai_baru);
                })
                ->exists();

            return !$isOverlap;
        }

        public function message()
        {
            return 'Waktu yang dipilih tumpang tindih dengan jadwal yang sudah ada atau sedang dalam proses.';
        }
    }
