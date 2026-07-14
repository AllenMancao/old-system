interface Profile {
    name: string;
    email: string;
    student_number: string;
    course: string;
    company: string;
    supervisor: string;
    year_level: number;
    start_date: string;
    end_date: string;
    required_hours: number;
    current_hours: number;
    status: string;
}

interface Props {
    profile: Profile;
}

export default function InternProfile({ profile }: Props) {
    const progress = Math.min(100, Math.round((profile.current_hours / profile.required_hours) * 100));

    return (
        <div className="mx-auto max-w-2xl p-8">
            <h1 className="mb-6 text-xl font-semibold">My Profile</h1>

            <div className="mb-6 rounded-lg border p-4">
                <p className="text-lg font-medium">{profile.name}</p>
                <p className="text-sm text-muted-foreground">{profile.email}</p>
                <span className="mt-2 inline-block rounded bg-muted px-2 py-1 text-xs font-medium">
                    {profile.status}
                </span>
            </div>

            <div className="grid grid-cols-2 gap-4">
                <Field label="Student Number" value={profile.student_number} />
                <Field label="Year Level" value={String(profile.year_level)} />
                <Field label="Course / Program" value={profile.course} />
                <Field label="Host Company" value={profile.company} />
                <Field label="Supervisor" value={profile.supervisor} />
                <Field label="Internship Period" value={`${profile.start_date} to ${profile.end_date}`} />
            </div>

            <div className="mt-6 rounded-lg border p-4">
                <div className="mb-2 flex justify-between text-sm">
                    <span>Hours Rendered</span>
                    <span className="font-medium">
                        {profile.current_hours} / {profile.required_hours} hrs
                    </span>
                </div>
                <div className="h-2 w-full rounded-full bg-muted">
                    <div className="h-2 rounded-full bg-black" style={{ width: `${progress}%` }} />
                </div>
            </div>
        </div>
    );
}

function Field({ label, value }: { label: string; value: string }) {
    return (
        <div>
            <p className="text-xs text-muted-foreground">{label}</p>
            <p className="text-sm font-medium">{value}</p>
        </div>
    );
}