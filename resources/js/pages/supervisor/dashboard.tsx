interface Intern {
    name: string;
    student_number: string;
    status: string;
    time_in: string | null;
    time_out: string | null;
    current_hours: number;
    required_hours: number;
}

interface Summary {
    total_interns: number;
    present_today: number;
    absent_today: number;
}

interface Props {
    interns: Intern[];
    summary: Summary;
}

const statusColors: Record<string, string> = {
    Present: 'bg-green-100 text-green-800',
    Late: 'bg-yellow-100 text-yellow-800',
    Absent: 'bg-red-100 text-red-800',
    Incomplete: 'bg-gray-100 text-gray-800',
};

export default function SupervisorDashboard({ interns, summary }: Props) {
    return (
        <div className="mx-auto max-w-4xl p-8">
            <h1 className="mb-6 text-xl font-semibold">Supervisor Dashboard</h1>

            <div className="mb-6 grid grid-cols-3 gap-4">
                <StatCard label="Total Interns" value={summary.total_interns} />
                <StatCard label="Present Today" value={summary.present_today} />
                <StatCard label="Absent Today" value={summary.absent_today} />
            </div>

            <div className="overflow-hidden rounded-lg border">
                <table className="w-full text-sm">
                    <thead className="bg-muted text-left">
                        <tr>
                            <th className="px-4 py-2 font-medium">Intern</th>
                            <th className="px-4 py-2 font-medium">Status</th>
                            <th className="px-4 py-2 font-medium">Time In</th>
                            <th className="px-4 py-2 font-medium">Time Out</th>
                            <th className="px-4 py-2 font-medium">Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        {interns.map((intern) => (
                            <tr key={intern.student_number} className="border-t">
                                <td className="px-4 py-3">
                                    <p className="font-medium">{intern.name}</p>
                                    <p className="text-xs text-muted-foreground">{intern.student_number}</p>
                                </td>
                                <td className="px-4 py-3">
                                    <span
                                        className={`rounded px-2 py-1 text-xs font-medium ${statusColors[intern.status] ?? 'bg-gray-100 text-gray-800'}`}
                                    >
                                        {intern.status}
                                    </span>
                                </td>
                                <td className="px-4 py-3">{intern.time_in ?? '—'}</td>
                                <td className="px-4 py-3">{intern.time_out ?? '—'}</td>
                                <td className="px-4 py-3">
                                    {intern.current_hours} / {intern.required_hours}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
}

function StatCard({ label, value }: { label: string; value: number }) {
    return (
        <div className="rounded-lg border p-4">
            <p className="text-xs text-muted-foreground">{label}</p>
            <p className="text-2xl font-semibold">{value}</p>
        </div>
    );
}