<?php

namespace vsmirnov\DDDCore\Monitoring;

interface MetricsGeneratorInterface
{
    public const METRIC_NAMESPACE = 'kpi_project';

    public function generate(): void;
}