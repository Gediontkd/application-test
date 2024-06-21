'use client';

import { useQuery } from "@apollo/client";
import { Card, List, Spin, Alert } from "antd";
import scheduleQuery from "./queries/scheduleQuery";
import dayjs from "dayjs";
import { SubsetInterface } from "../../../types/DataModelTypes/SubsetInterface";
import { EventInterface } from "../../../types/DataModelTypes/EventInterface";
import Link from "next/link";

export default function Schedule() {
    // Use the useQuery hook to fetch data, including loading and error states
    const { data, loading, error } = useQuery<{ eventsSubset: SubsetInterface<EventInterface> }>(
        scheduleQuery,
        {
            fetchPolicy: "network-only",
            nextFetchPolicy: "cache-first",
            variables: {
                limit: 10,
                offset: 0,
                startDate: dayjs().startOf("day").toISOString()
            }
        }
    );

    // Show a loading spinner while the data is being fetched
    if (loading) {
        return (
            <Card>
                <Spin tip="Loading...">
                    <List />
                </Spin>
            </Card>
        );
    }

    // Show an error message if there is an error fetching the data
    if (error) {
        return (
            <Card>
                <Alert
                    message="Error"
                    description="There was an error fetching the schedule data."
                    type="error"
                    showIcon
                />
            </Card>
        );
    }

    // Render the list of events once the data is successfully fetched
    return (
        <Card>
            <List
                dataSource={data?.eventsSubset.items ?? []}
                renderItem={event => (
                    <List.Item
                        key={event.id}
                        actions={[<Link href={`/events/${encodeURIComponent(event.id)}`}>Detail</Link>]}
                    >
                        <List.Item.Meta
                            title={<>{dayjs(event.date).format('L')} - {event.name}</>}
                            description={event.program?.map(speech => speech.speaker).join(", ")}
                        />
                    </List.Item>
                )}
            />
        </Card>
    );
}
